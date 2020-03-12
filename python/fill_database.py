import mysql.connector
import json

viravira_db = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="1234",
    database="viravira",
    auth_plugin="mysql_native_password"
)

with open(r"../data/excursionsAPI.json") as file:
    data = json.load(file)

    for excursion in data['list']:
        title = excursion['title']
        excursion_type = excursion['type']
        thumbnail = excursion['images'][0]['url'][46:]
        images = list(map(lambda img: img['url'][46:], excursion['images']))
        descriptions = excursion['description']['detail']
        details = {}
        for key, value in excursion['description']['table'].items():
            key = key.capitalize().replace('-', ' ')
            details[key] = value

        sql = "INSERT INTO excursion (title, type, thumbnail_url) VALUES (%s, %s, %s)"
        val = (title, excursion_type, thumbnail)

        cursor = viravira_db.cursor()
        cursor.execute(sql, val)
        viravira_db.commit()

        excursion_id = cursor.lastrowid

        for key, value in details.items():
            sql = "INSERT INTO excursion_detail (excursion_id, detail_key, detail_value) VALUES (%s, %s, %s)"
            val = (excursion_id, key, value)
            cursor.execute(sql, val)
            viravira_db.commit()

        for description in descriptions:
            sql = "INSERT INTO excursion_description (excursion_id, header, description) VALUES (%s, %s, %s)"
            val = (excursion_id, description['header'], description['text'])
            cursor.execute(sql, val)
            viravira_db.commit()

        for image in images:
            sql = "INSERT INTO excursion_image (excursion_id, image_url) VALUES (%s, %s)"
            val = (excursion_id, image)
            cursor.execute(sql, val)
            viravira_db.commit()
