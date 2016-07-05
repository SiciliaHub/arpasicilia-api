#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
import xlrd
import datetime
import csv
import time
import MySQLdb
import requests

from config import *

stazioni_id = {}
stazioni_id['ex_autoparco'] = 1
stazioni_id['parcheggio_agip'] = 2
stazioni_id['misterbianco'] = 3
stazioni_id['enna'] = 4
stazioni_id['cda_gabbia'] = 5
stazioni_id['boccetta'] = 6
stazioni_id['termica_milazzo'] = 7
stazioni_id['partinico'] = 8
stazioni_id['termini'] = 9
stazioni_id['Marcellino'] = 10
stazioni_id['megara'] = 11
stazioni_id['trapani'] = 12
stazioni_id['Lab_Mobile_1'] = 13
stazioni_id['Lab_Mobile_4'] = 14
stazioni_id['PORTO EMPEDOCLE'] = 15
stazioni_id['VILLA AUGUSTA'] = 16
stazioni_id['sasol'] = 17
stazioni_id['CAPACI'] = 18
stazioni_id['ISOLA DELLE FEMMINE'] = 19

def minimalist_xldate_as_datetime(xldate, datemode):
    # datemode: 0 for 1900-based, 1 for 1904-based
    return (datetime.datetime(1899, 12, 30) + datetime.timedelta(days=xldate + 1462 * datemode))


def extract_attributes_from_title(title):
    stazioni=['partinico', 'enna', 'ex_autoparco', 'parcheggio_agip', 'trapani', 'termini', 'Marcellino', 'cda_gabbia', 'termica_milazzo', 'boccetta', 'misterbianco', 'megara', 'Lab_Mobile_1', 'Lab_Mobile1', 'PORTO EMPEDOCLE', 'VILLA AUGUSTA', 'Lab_Mobile_4','CAPACI', 'ISOLA DELLE FEMMINE', 'sasol']
    inquinanti = ['SO2','CO', 'NO2', 'O3', 'PM 10', 'Benzene', 'PM 2.5']
    
    reconciliation = ["Lab_Mobile_4_SO2","VILLA AUGUSTA_SO2","PORTO EMPEDOCLE_SO2","Lab_Mobile_1_SO2", "Lab_Mobile1"]
    
    for item in reconciliation:
        if item in title:
            title = title.replace("_SO2", " SO2")
            title = title.replace("Lab_Mobile1", "Lab_Mobile_1")
            break
            
    attributes = []
        
    for item in stazioni:
        if item in title:
            attributes.append(stazioni_id[item])
            
    for item in inquinanti:
        if item in title:
            attributes.append(item.replace(' ',''))
            
    um = title[title.find("(")+1:title.find(")")]
    attributes.append(um)
    
    return attributes

db = MySQLdb.connect(host= db_host, user=db_user,  passwd=db_password, db= db_name)

try:
    os.remove('report.xls')
except:
    pass

url = 'http://www.arpa.sicilia.it/storage/MAria_report.xls'
print "Downloading Maria report from ARPA Sicilia Website"
r = requests.get(url)
with open("report.xls", "wb") as code:
    code.write(r.content)

print "Load data into DB"

book = xlrd.open_workbook("report.xls",  encoding_override="utf8")
sh = book.sheet_by_index(0)

col_start = 26
col_useful = 160
col_end = 160 + col_start

cursor = db.cursor()

cursor.execute("truncate table misurazioni")
db.commit()

for row in range(2, sh.nrows):      
    date = minimalist_xldate_as_datetime(sh.cell_value(row,24), 0)
    
    for col in range(col_start,col_end):
        row_values = []
        title_col = sh.cell_value(0, col)
        subtitle_col = sh.cell_value(1,col)
        
        value =  sh.cell_value(row, col)

        if value != '':
            row_values.append(date)
            row_values = row_values + extract_attributes_from_title(title_col)
            row_values.append(subtitle_col)
            row_values.append(value)
                       
            sql = "INSERT INTO `misurazioni` (`data`, `id_stazione`,`inquinante`, `um`, `tipologia_misurazione`, `valore`) VALUES (%s,%s,%s,%s,%s,%s)"
             
            cursor.execute(sql, (row_values))

db.commit()

