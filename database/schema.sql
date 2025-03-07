CREATE DATABASE IF NOT EXISTS env;
USE env;

CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    avatar VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    phoneNumber VARCHAR(20),
    points INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS Admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Authorities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contactEmail VARCHAR(255),
    contactPhone VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS Locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    coordinates VARCHAR(100),
    description TEXT,
    status ENUM('active', 'inactive', 'pending') DEFAULT 'active',
    authorityId INT,
    FOREIGN KEY (authorityId) REFERENCES Authorities(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    locationId INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    status ENUM('pending', 'reviewed', 'resolved') DEFAULT 'pending',
    submit DATETIME DEFAULT CURRENT_TIMESTAMP,
    multipleChoiceSelection INT,
    FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (locationId) REFERENCES Locations(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reportId INT,
    userId INT,
    commentText TEXT,
    commentDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reportId) REFERENCES Reports(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ChallengeTasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    challengeId INT,
    taskName VARCHAR(255) NOT NULL,
    taskDescription TEXT,
    points INT DEFAULT 0,
    status ENUM('active', 'completed') DEFAULT 'active'
);

CREATE TABLE IF NOT EXISTS UserChallengeTasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    challengeTaskId INT,
    userId INT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    submit DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (challengeTaskId) REFERENCES ChallengeTasks(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Points (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    pointsEarned INT DEFAULT 0,
    dateEarned DATETIME DEFAULT CURRENT_TIMESTAMP,
    pointSourceId INT,
    FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS PointSources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sourceType VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS RequestPoints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    pointsRequested INT NOT NULL,
    proof TEXT ,
    message TEXT ,
    status ENUM('pending', 'approved', 'denied') DEFAULT 'pending',
    requestDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS FAQs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    contactInfo VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Statistics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    locationId INT,
    treesPlanted INT DEFAULT 0,
    reportsSubmitted INT DEFAULT 0,
    pointsEarned INT DEFAULT 0,
    FOREIGN KEY (locationId) REFERENCES Locations(id) ON DELETE CASCADE
);

-- إدراج بيانات في جدول المستخدمين
INSERT INTO Users (fullName, email, password, phoneNumber, points) VALUES
('أحمد العتيبي', 'ahmad@example.com', 'password123', '966501234567', 50),
('سارة القحطاني', 'sara@example.com', 'password123', '966502345678', 30),
('محمد الدوسري', 'mohammed@example.com', 'password123', '966503456789', 40),
('نورة الشهري', 'noura@example.com', 'password123', '966504567890', 20),
('عبدالله الزهراني', 'abdullah@example.com', 'password123', '966505678901', 60);

-- إدراج بيانات في جدول الإداريين
INSERT INTO Admins (name, email, password) VALUES
('خالد السبيعي', 'khaled@example.com', '$2y$10$IhLTwmKMC0nA9O/fQqRJYOaSkjQEtm8LSFUOSzNCEHJrpHI4iW1tu'),
('منال العتيبي', 'manal@example.com', '$2y$10$IhLTwmKMC0nA9O/fQqRJYOaSkjQEtm8LSFUOSzNCEHJrpHI4iW1tu'),
('فيصل الشهراني', 'faisal@example.com', '$2y$10$IhLTwmKMC0nA9O/fQqRJYOaSkjQEtm8LSFUOSzNCEHJrpHI4iW1tu'),
('ريم الغامدي', 'reem@example.com', '$2y$10$IhLTwmKMC0nA9O/fQqRJYOaSkjQEtm8LSFUOSzNCEHJrpHI4iW1tu'),
('بدر الحربي', 'badr@example.com', '$2y$10$IhLTwmKMC0nA9O/fQqRJYOaSkjQEtm8LSFUOSzNCEHJrpHI4iW1tu');

-- إدراج بيانات في جدول السلطات
INSERT INTO Authorities (name, contactEmail, contactPhone) VALUES
('وزارة البيئة', 'env@example.com', '966600123456'),
('هيئة الحماية', 'protection@example.com', '966601234567'),
('الأمانة العامة', 'amanah@example.com', '966602345678'),
('الدفاع المدني', 'civildef@example.com', '966603456789'),
('وزارة الصحة', 'health@example.com', '966604567890');

-- إدراج بيانات في جدول المواقع
INSERT INTO Locations (name, coordinates, description, status, authorityId) VALUES
('حديقة الرياض', '24.7136,46.6753', 'حديقة جميلة مليئة بالأشجار.', 'active', 1),
('محمية الطائف', '21.2854,40.4265', 'منطقة محمية للحيوانات البرية.', 'active', 2),
('كورنيش جدة', '21.4858,39.1925', 'مكان رائع للمشي بجانب البحر.', 'active', 3),
('المدينة القديمة', '24.4710,39.6117', 'منطقة تاريخية تضم مبانٍ قديمة.', 'pending', 4),
('غابة الباحة', '20.0128,41.4670', 'غابة طبيعية مليئة بالحياة البرية.', 'inactive', 5);

-- إدراج بيانات في جدول البلاغات
INSERT INTO Reports (userId, locationId, description, image, status, multipleChoiceSelection) VALUES
(1, 1, 'تم رصد أشجار مقطوعة بشكل غير قانوني.', 'report1.jpg', 'pending', 3),
(2, 2, 'الحيوانات البرية مهددة بالخطر بسبب الصيد.', 'report2.jpg', 'reviewed', 2),
(3, 3, 'يتم إلقاء النفايات بالقرب من البحر.', 'report3.jpg', 'pending', 1),
(4, 4, 'مبنى تاريخي معرض للهدم.', 'report4.jpg', 'resolved', 4),
(5, 5, 'حرائق غير مسيطر عليها بالغابة.', 'report5.jpg', 'pending', 5);

-- إدراج بيانات في جدول التعليقات
INSERT INTO Comments (reportId, userId, commentText) VALUES
(1, 2, 'يجب إبلاغ الجهات المختصة فوراً.'),
(2, 3, 'هذا أمر خطير! يجب التصرف بسرعة.'),
(3, 4, 'أتمنى أن يتم تنظيف الموقع قريباً.'),
(4, 5, 'هل هناك أي تحديث بخصوص هذه المشكلة؟'),
(5, 1, 'تمت مشاركة التقرير مع الجهات المختصة.');

-- إدراج بيانات في جدول المهام التحدي
INSERT INTO ChallengeTasks (challengeId, taskName, taskDescription, points, status) VALUES
(1, 'زراعة شجرة', 'قم بزراعة شجرة في منطقتك.', 10, 'active'),
(2, 'تنظيف الحديقة', 'ساعد في تنظيف حديقة عامة.', 15, 'active'),
(3, 'إعادة التدوير', 'قم بإعادة تدوير المواد البلاستيكية.', 20, 'completed'),
(4, 'الإبلاغ عن مخالفة بيئية', 'قدم بلاغاً عن انتهاك بيئي.', 10, 'active'),
(5, 'نشر الوعي البيئي', 'شارك معلومات بيئية على وسائل التواصل.', 5, 'active');

-- إدراج بيانات في جدول مهام المستخدمين
INSERT INTO UserChallengeTasks (challengeTaskId, userId, status) VALUES
(1, 1, 'completed'),
(2, 2, 'pending'),
(3, 3, 'completed'),
(4, 4, 'pending'),
(5, 5, 'completed');

-- إدراج بيانات في جدول النقاط
INSERT INTO Points (userId, pointsEarned, pointSourceId) VALUES
(1, 50, 1),
(2, 30, 2),
(3, 40, 3),
(4, 20, 4),
(5, 60, 5);

-- إدراج بيانات في جدول مصادر النقاط
INSERT INTO PointSources (sourceType, description) VALUES
('مهمة بيئية', 'إتمام تحدي بيئي لكسب النقاط.'),
('التطوع', 'المشاركة في الأنشطة التطوعية.'),
('الإبلاغ', 'الإبلاغ عن الانتهاكات البيئية.'),
('التثقيف', 'نشر التوعية البيئية.'),
('إعادة التدوير', 'المشاركة في حملات إعادة التدوير.');

-- إدراج بيانات في جدول طلبات النقاط
INSERT INTO RequestPoints (userId, pointsRequested, proof, status) VALUES
(1, 20, 'proof1.jpg', 'approved'),
(2, 15, 'proof2.jpg', 'pending'),
(3, 10, 'proof3.jpg', 'denied'),
(4, 25, 'proof4.jpg', 'approved'),
(5, 30, 'proof5.jpg', 'pending');

-- إدراج بيانات في جدول الأسئلة الشائعة
INSERT INTO FAQs (question, answer, contactInfo) VALUES
('كيف يمكنني الإبلاغ عن مشكلة بيئية؟', 'يمكنك استخدام التطبيق للإبلاغ وإرفاق الصور.', 'contact@example.com'),
('كيف أكسب النقاط؟', 'يمكنك كسب النقاط من خلال إتمام التحديات.', 'contact@example.com'),
('ما هي أنواع التحديات المتاحة؟', 'تشمل الزراعة، التنظيف، التوعية، وإعادة التدوير.', 'contact@example.com'),
('هل يمكنني استبدال النقاط؟', 'نعم، يمكن استبدال النقاط بالمكافآت البيئية.', 'contact@example.com'),
('كيف يمكنني التطوع؟', 'يمكنك التسجيل عبر التطبيق والمشاركة.', 'contact@example.com');

-- إدراج بيانات في جدول الإحصائيات
INSERT INTO Statistics (locationId, treesPlanted, reportsSubmitted, pointsEarned) VALUES
(1, 100, 10, 500),
(2, 50, 8, 400),
(3, 30, 15, 300),
(4, 70, 12, 600),
(5, 90, 20, 700);
