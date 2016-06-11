#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
import datetime
import MySQLdb
import MySQLdb.cursors
from datetime import datetime

from config import *

db = MySQLdb.connect(host= db_host, user=db_user, passwd=db_password, db= db_name, cursorclass=MySQLdb.cursors.DictCursor)

cursor = db.cursor()

cursor.execute("truncate table iqa")
db.commit()

print 'Aggiornamento IQA...'

for stazione in range(1,18):

    sql = "select data, id_stazione, inquinante, tipologia_misurazione, um, valore from misurazioni where \
    ((inquinante like 'PM10' and tipologia_misurazione like 'Media 24 h') OR \
    (inquinante like 'O3' and tipologia_misurazione like 'Max media 8h') OR \
    (inquinante like 'NO2' and tipologia_misurazione like 'Max orario')) and id_stazione = %s \
    group by data, inquinante"
    
    cursor.execute(sql, (stazione,))
    
    results = {}
    for row in cursor.fetchall():
        data = row['data'].strftime('%Y-%m-%d')
        if data not in results:
            results[data] = []
        results[data].append(row)
    
    
    for data in results:
        indexNO2 = -1
        indexPM10 = -1
        indexO3 = -1
        
        id_stazione = 0
       
        if len(results[data]) == 3:
            for r in results[data]:
                id_stazione = r['id_stazione']
                if r['inquinante'] == 'NO2':
                    indexNO2 = round((r['valore'] / 200 * 100), 2)
                elif r['inquinante'] == 'PM10':
                    indexPM10 = round((r['valore'] / 50 * 100), 2)
                elif r['inquinante'] == 'O3':
                    indexO3 = round((r['valore'] / 120 * 100), 2)
            
            if indexNO2!=-1 and indexPM10 !=-1 and indexO3 !=-1:
                iqa = max(indexNO2, indexPM10, indexO3)
                datetime = datetime.strptime(data, '%Y-%m-%d')
                sql = "INSERT INTO `iqa` (`data`, `id_stazione`, `valore`) VALUES (%s,%s,%s)"
                cursor.execute(sql, (datetime, id_stazione, iqa ))
db.commit()   
                
print 'Fatto'

