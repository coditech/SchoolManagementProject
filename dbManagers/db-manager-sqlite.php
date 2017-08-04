<?php try {
    $db = new PDO('sqlite:sample.sqlite3');
}
catch (PDOException $e) {
    echo $e->getMessage();
    die();
}


$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS person
                                            (
                                                id INT NOT NULL ,
                                                name VARCHAR(255),
                                                lastName VARCHAR(255),
                                                gender VARCHAR(30),
                                                email VARCHAR(255),
                                                telephone VARCHAR(20),
                                                userType VARCHAR(255),
                                                username VARCHAR(255),
                                                password VARCHAR(255),
                                                date DATE  ,
                                                PRIMARY KEY(id)
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS grade
                                            (
                                                id INT NOT NULL ,
                                                score DOUBLE,
                                                semester INT,
                                                year INT,
                                                courseId INT,
                                                studentId INT,
                                                PRIMARY KEY(id)
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS article
                                            (
                                                id INT NOT NULL ,
                                                title VARCHAR(255),
                                                text VARCHAR(255),
                                                date DATE ,
                                                PRIMARY KEY(id)
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS course
                                            (
                                                id INT NOT NULL , 
                                                courseCode VARCHAR(255),
                                                courseName VARCHAR(255),
                                                courseMaxGrade INT,
                                                courseYear INT,
                                                courseClass VARCHAR(255),
                                                teacherId INT,
                                                PRIMARY KEY(id)
                                            );");                                            


$db->exec("CREATE TABLE IF NOT EXISTS message
                                            (
                                                senderId INT NOT NULL,
                                                recipientId INT NOT NULL,
                                                date DATE ,
                                                text TEXT,
                                                PRIMARY KEY(senderId, recipientId, date)
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS image
                                            (
                                                id INT NOT NULL ,
                                                pathToImg VARCHAR(255),
                                                articleId INT,
                                                PRIMARY KEY(id)
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS student
                                            (
                                                id INT NOT NULL ,
                                                parentId INT,
                                                class VARCHAR(255),
                                                PRIMARY KEY(id)
                                            );");
                                            
?>