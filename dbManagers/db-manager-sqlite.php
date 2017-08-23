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
                                                id INT  PRIMARY KEY,
                                                name VARCHAR(255),
                                                lastName VARCHAR(255),
                                                gender VARCHAR(30),
                                                email VARCHAR(255),
                                                telephone VARCHAR(20),
                                                userType VARCHAR(255),
                                                username VARCHAR(255),
                                                password VARCHAR(255),
                                                date DATE  
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS grade
                                            (
                                                id INT  PRIMARY KEY AUTOINCREMENT ,
                                                score DOUBLE,
                                                semester INT,
                                                year INT,
                                                courseId INT,
                                                studentId INT
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS article
                                            (
                                                id INT  PRIMARY KEY AUTOINCREMENT ,
                                                title VARCHAR(255),
                                                text VARCHAR(255),
                                                date DATE
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS course
                                            (
                                                id INT  PRIMARY KEY AUTOINCREMENT, 
                                                courseCode VARCHAR(255),
                                                courseName VARCHAR(255),
                                                courseMaxGrade INT,
                                                courseYear INT,
                                                courseClass VARCHAR(255),
                                                teacherId INT
                                            );");                                            


$db->exec("CREATE TABLE IF NOT EXISTS message
                                            (
                                                senderId INT ,
                                                recipientId INT,
                                                date DATE ,
                                                text TEXT,
                                                PRIMARY KEY(senderId, recipientId, date)
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS image
                                            (
                                                id INT  PRIMARY KEY AUTOINCREMENT,
                                                pathToImg VARCHAR(255),
                                                articleId INT
                                            );");

$db->exec("CREATE TABLE IF NOT EXISTS student
                                            (
                                                id INT  PRIMARY KEY AUTOINCREMENT,
                                                parentId INT,
                                                class VARCHAR(255)
                                            );");
                                            
?>