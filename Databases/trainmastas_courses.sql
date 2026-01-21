-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 12:28 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainmastas_courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_ID` varchar(37) NOT NULL,
  `user_ID` varchar(37) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Category` varchar(70) NOT NULL,
  `Cover_image` varchar(70) NOT NULL,
  `Cost` decimal(5,2) NOT NULL,
  `action` varchar(1) NOT NULL,
  `Num_modules` tinyint(2) NOT NULL,
  `Num_test` tinyint(2) NOT NULL,
  `Date` datetime NOT NULL,
  `validated_date` datetime DEFAULT NULL,
  `submitted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_ID`, `user_ID`, `Title`, `Description`, `Category`, `Cover_image`, `Cost`, `action`, `Num_modules`, `Num_test`, `Date`, `validated_date`, `submitted_date`) VALUES
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'a5636c14-1a09-40ab-8863-98253ee2c659', 'Python Basics - Your First Steps In Python Programming', 'This course provides a comprehensive introduction to the Python programming language. Designed for beginners with little to no prior programming experience, it will guide you through the fundamental syntax, data structures, and control flow of Python. You will learn how to write simple Python scripts, understand core programming concepts within the Python ecosystem, and build a solid foundation for more advanced Python topics.', 'Technology &amp; IT', '6800d3554408f.jpeg', '0.00', 'e', 7, 10, '2025-04-17 11:35:13', NULL, '2025-04-02 16:11:29'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'a5636c14-1a09-40ab-8863-98253ee2c659', 'Java Basics - Your First Steps In Java Programming', 'This course provides a foundational understanding of the Java programming language. Designed for individuals with little to no prior programming experience, it will guide you through the essential syntax, core concepts, and fundamental principles of Java. You will learn about object-oriented programming concepts as implemented in Java, how to write and execute basic Java programs, and build a solid stepping stone for more advanced Java development.', 'Technology &amp; IT', '6803a7a6593c1.png', '0.00', 'e', 7, 0, '2025-04-19 15:54:33', NULL, '2025-04-01 16:11:25'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'a5636c14-1a09-40ab-8863-98253ee2c659', 'Introduction To Programming - Your First Steps Into Code', 'This course provides a foundational understanding of the core concepts and principles of programming. Designed for absolute beginners with no prior coding experience, it will guide you through the essential building blocks of software development. You will learn about fundamental programming concepts, common programming paradigms, and gain hands-on experience through practical examples. By the end of this course, you will have a solid understanding of what programming is, be familiar with basic ', 'Technology &amp; IT', '67fcf0d82971d.jpeg', '0.00', 'e', 8, 20, '2025-04-14 12:46:27', NULL, '2025-04-01 16:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `courses_rejected`
--

CREATE TABLE `courses_rejected` (
  `course_ID` varchar(37) NOT NULL,
  `Reason` varchar(210) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_feedback`
--

CREATE TABLE `course_feedback` (
  `course_ID` varchar(37) NOT NULL,
  `feedback_giver_ID` varchar(37) NOT NULL,
  `Feedback` varchar(200) NOT NULL,
  `Rate` varchar(2) NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_modules`
--

CREATE TABLE `course_modules` (
  `course_ID` varchar(37) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Module_num` tinyint(2) NOT NULL,
  `Description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_modules`
--

INSERT INTO `course_modules` (`course_ID`, `Title`, `Module_num`, `Description`) VALUES
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Introduction To Python - Setup And Produce Your First Program', 1, 'This module introduces the Python programming language, its history, and its applications. We will guide you through the process of setting up your Python development environment and writing your very first Python program.'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Variables, Data Types, And Operators In Python', 2, 'This module delves into the fundamental building blocks of Python: variables and data types. You will learn how to declare and use variables to store data, understand different data types (integers, floats, strings, booleans), and work with various operators (arithmetic, comparison, logical).'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Control Flow - Conditional Statements In Python', 3, 'This module introduces how to make decisions in your Python programs using conditional statements (if, elif, else). You will learn how to control the flow of execution based on different conditions.'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Control Flow - Loops In Python', 4, 'In this module, you will learn how to automate repetitive tasks using loops (for and while) in Python. We will explore different ways to iterate through data and execute code blocks multiple times.'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Functions In Python - Organizing Code', 5, 'This module introduces the concept of functions in Python. You will learn how to define your own functions, pass arguments, and return values, which is essential for writing modular and reusable code. Good one.'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Data Structures - Lists And Tuples In Python', 6, 'This module introduces two fundamental data structures in Python: lists and tuples. You will learn how to create, access, and manipulate these ordered collections of items. We will also discuss the key differences between them.'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Data Structures - Dictionaries In Python', 7, 'This module introduces another essential data structure in Python: dictionaries. You will learn how to store and retrieve data using key-value pairs, which provides a flexible and efficient way to organize information.'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Introduction To Java - Setup And First Program', 1, 'This module introduces the Java programming language, its history, key features, and its applications across various platforms. We will guide you through setting up your Java Development Kit (JDK) and a basic Integrated Development Environment (IDE), and then writing and running your first Java program.'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Data Types, Variables, And Operators In Java', 2, 'This module explores the fundamental data types in Java: primitive and reference, how to declare and initialize variables to store data, and the various types of operators available in Java (arithmetic, relational, logical, assignment).'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Control Flow - Decision Making In Java', 3, 'This module focuses on how to control the flow of execution in your Java programs using decision-making statements such as if, else, and switch. You will learn how to execute different blocks of code based on specific conditions.'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Control Flow - Looping In Java', 4, 'In this module, you will learn how to automate repetitive tasks using looping constructs in Java, including for, while, and do-while loops. We will explore different scenarios for using each type of loop.'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Introduction To Object-Oriented Programming (OOP) In Java', 5, 'This module introduces the fundamental concepts of Object-Oriented Programming (OOP) as implemented in Java. We will conceptually explore Encapsulation, Inheritance, and Polymorphism, laying the groundwork for understanding how Java organizes code using objects and classes.'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Classes And Objects In Java', 6, 'Building upon the previous module, this module delves into the practical aspects of creating and using classes and objects in Java. You will learn how to define classes with attributes(fields) and behaviors (methods), and how to instantiate objects from these classes.'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Basic Input/Output And Exception Handling In Java', 7, 'This module introduces how to handle basic input from the user and display output in Java using the Scanner class and System.out.println(). We will also touch upon the concept of exception handling using try-catch blocks to manage potential errors during program execution.'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'What Is Programming? Why Learn To Code?', 1, 'This module introduces the fundamental concept of programming and its relevance in today\'s world. We\'ll explore what it means to write code, how computers execute instructions, and the diverse applications of programming across various industries. We\'ll also discuss the benefits of learning to code and the exciting opportunities it can unlock.'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Getting Started - Understanding The Basics', 2, 'This module dives into the fundamental building blocks of programming. We will introduce the concepts of algorithms, pseudocode, and flowcharts as ways to plan and represent program logic before writing actual code. We\'ll also touch upon the idea of different programming languages and their roles.'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Variables And Data Types - Unserstand Storing Information', 3, 'This module introduces the crucial concepts of variables and data types. You will learn how to store and manipulate data within a program using variables. We will explore common data types such as integers, floating-point numbers, strings, and booleans, and understand their purpose and usage.'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Operators And Expressions - Performing Actions', 4, 'In this module, you will learn about operators, which are symbols that perform operations on values and variables. We will cover arithmetic operators, comparison operators, and logical operators. You will also understand how to combine these operators to form expressions that evaluate to a specific value.'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Control Flow - Making Decisions And Repeating Actions', 5, 'This module introduces the essential concepts of control flow, which allows programs to make decisions and execute blocks of code repeatedly. We will explore conditional statements (if, else, elif/else if) and looping structures (for loops, while loops).'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Functions - Organizing Your Code', 6, 'This module introduces the concept of functions, which are reusable blocks of code that perform specific tasks. You will learn how to define functions, pass arguments to them, and return values. Functions are crucial for writing modular and organized code.'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Introduction To Data Structures - Organizing Collections Of Data', 7, 'This module provides a basic introduction to fundamental data structures, which are ways to organize and store collections of data efficiently. We will briefly touch upon concepts like lists (or arrays) and how they can be used to manage multiple values.'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'What\'s Next? - Exploring Further', 8, 'This final module provides guidance on where to go next in your programming journey. We will briefly discuss different programming languages and their common applications (e.g., web development, data science, game development). We\'ll also highlight resources for continued learning and practice.');

-- --------------------------------------------------------

--
-- Table structure for table `course_registered`
--

CREATE TABLE `course_registered` (
  `course_ID` varchar(37) NOT NULL,
  `user_ID` varchar(37) NOT NULL,
  `Level` varchar(2) NOT NULL DEFAULT '1',
  `certificate_ID` varchar(23) DEFAULT NULL,
  `Date` datetime NOT NULL,
  `certificate_Date` datetime DEFAULT NULL,
  `certificate_expired_Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_registered`
--

INSERT INTO `course_registered` (`course_ID`, `user_ID`, `Level`, `certificate_ID`, `Date`, `certificate_Date`, `certificate_expired_Date`) VALUES
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '7d1fc16e-3549-4de5-a05b-55d2f679e897', 'c', 'ottwz-ldf21-vuwcd-1yhx2', '2025-04-17 15:10:01', '2025-04-17 16:27:28', '2027-04-21 01:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `course_scope`
--

CREATE TABLE `course_scope` (
  `course_ID` varchar(37) NOT NULL,
  `Scope` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_scope`
--

INSERT INTO `course_scope` (`course_ID`, `Scope`) VALUES
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Backend Development'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Frontend Development'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'Web Development'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'And Polymorphism'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Creating and using classes and obje'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Encapsulation'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Handling exceptions in Java'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Implementing control flow statement'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Inheritance'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Software Engineering'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Understanding the basic syntax of J'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Variables of Java'),
('964d3651-f24a-40ad-a40c-693e23517ee7', 'Working with data types'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Backend Development'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Data Science'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Frontend Development'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Full Stack Development'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Master coding'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `course_score`
--

CREATE TABLE `course_score` (
  `course_ID` varchar(37) NOT NULL,
  `user_ID` varchar(37) NOT NULL,
  `Attempt_num` int(1) NOT NULL,
  `Answers` varchar(120) NOT NULL,
  `Score` varchar(2) NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_score`
--

INSERT INTO `course_score` (`course_ID`, `user_ID`, `Attempt_num`, `Answers`, `Score`, `Date`) VALUES
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '7d1fc16e-3549-4de5-a05b-55d2f679e897', 1, 'n,n,n,n,n,n,n,n,n,n', '0', '2025-03-17 16:12:32'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '7d1fc16e-3549-4de5-a05b-55d2f679e897', 2, 'd,c,c,b,n,c,c,b,a,b', '9', '2025-04-17 16:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `course_test`
--

CREATE TABLE `course_test` (
  `course_ID` varchar(37) NOT NULL,
  `Question_num` varchar(2) NOT NULL,
  `Question` varchar(150) NOT NULL,
  `Option_A` varchar(50) NOT NULL,
  `Option_B` varchar(50) NOT NULL,
  `Option_C` varchar(50) NOT NULL,
  `Option_D` varchar(50) NOT NULL,
  `Answer` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_test`
--

INSERT INTO `course_test` (`course_ID`, `Question_num`, `Question`, `Option_A`, `Option_B`, `Option_C`, `Option_D`, `Answer`) VALUES
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '1', 'What is the correct syntax to print \"Hello, World!\" in Python?', 'Print \"Hello, World!\"', 'Echo \"Hello, World!\";', 'System.out.println(\"Hello, World!\");', 'Print(\"Hello, World!\")', 'd'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '10', 'How do you access the value associated with the key \'name\' in a Python dictionary called my_dict?', 'My_dict(\'name\')', 'My_dict[\'name\']', 'My_dict.name', 'My_dict[0]', 'b'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '2', 'Which of the following is a valid variable name in Python?', '1variable', 'My-variable', '_my_variable', 'Class', 'c'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '3', 'What data type is used to store decimal numbers in Python?', 'Int', 'Str', 'Float', 'Bool', 'c'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '4', 'Which operator is used to check if two values are equal in Python?', '=', '==', '<>', '!=', 'b'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '5', 'What will the following Python code output?\n\nx = 5\nif x > 10:\n    print(\"Greater than 10\")\nelse:\n    print(\"Less than or equal to 10\")', 'Greater than 10', 'Less than or equal to 10', 'Nothing will be printed.', 'An error will occur.', 'b'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '6', 'How many times will the following loop execute?\nfor i in range(3):\n    print(i)', '0', '2', '3', '4', 'c'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '7', 'What is the purpose of the def keyword in Python?', 'To define a variable.', 'To define a loop.', 'To define a function.', 'To define a class.', 'c'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '8', 'What will the following Python code return?\n\ndef add(a, b):\n    return a + b\n\nresult = add(2, 3)', 'Add', '5', 'A + b', 'None', 'b'),
('7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '9', 'Which of the following is a mutable data structure in Python?', 'List', 'Tuple', 'Interger', 'String', 'a'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '1', 'What is the primary purpose of programming?', 'To create computer hardware.', 'To create instructions for computers to perform ta', 'To manage computer networks.', 'To repair computer systems.', 'b'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '10', 'What is the purpose of an if statement in programming?', 'To execute a block of code indefinitely.', 'To define a function.', 'To store a collection of data.', 'To execute a block of code only if a certain condi', 'd'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '11', 'What is a function in programming?', 'A type of variable.', 'A loop that runs forever.', 'A way to store different data types together.', 'A reusable block of code that performs a specific', 'd'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '12', 'What are arguments in the context of functions?', 'The lines of code inside the function.', 'Values passed into a function when it is called.', 'The name given to a function.', 'The value returned by a function.', 'b'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '13', 'What is a common use case for a list (or array) in programming?', 'Storing a single value.', 'Organizing a collection of related data.', 'Defining the structure of a function.', 'Performing arithmetic operations.', 'b'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '14', 'How are elements typically accessed in a list or array?', 'By their data type.', 'By their variable name.', 'By their index (position).', 'By their function name.', 'c'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '15', 'Which programming language is often used for web development?', 'Binary code', 'Assembly language', 'Python', 'HTML/CSS (while not strictly programming languages', 'd'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '16', 'Which field commonly utilizes programming for data analysis and machine learning?', 'Culinary arts', 'Data science', 'Architecture', 'Fashion design', 'b'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '17', 'What is a good first step when learning a new programming language?', 'Immediately trying to build complex applications.', 'Understanding the basic syntax and fundamental con', 'Memorizing all the library functions.', 'Focusing only on advanced topics.', 'b'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '18', 'Online coding platforms and communities are useful for:', 'Only for experienced programmers.', 'Practicing coding skills and getting help.', 'Replacing the need to learn programming fundamenta', 'Primarily for downloading pirated software.', 'b'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '19', 'What is the importance of breaking down complex problems into smaller steps when programming?', 'It makes the problem easier to understand and solv', 'It makes the code run faster.', 'It reduces the number of lines of code.', 'It automatically generates the solution.', 'a'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '2', 'Which of the following is a common benefit of learning to code?', 'Becoming a professional gamer.', 'Becoming a data entry specialist.', 'Mastering graphic design.', 'Improving problem-solving skills.', 'd'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '20', 'After completing an introductory programming course, what is a recommended next step?', 'Stop learning and assume you know everything.', 'Immediately apply for senior developer positions.', 'Forget everything you learned.', 'Choose a specific programming language or area to', 'd'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '3', 'What is an algorithm in the context of programming?', 'A step-by-step procedure to solve a problem.', 'A specific programming language.', 'A type of computer hardware.', 'A method for organizing files.', 'a'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '4', 'Pseudocode is used for:', 'Writing final, executable code.', 'Debugging errors in code.', 'Compiling code into machine language.', 'Representing program logic in a human-readable for', 'd'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '5', 'Which of the following is an example of a variable?', '7', '\"Hello\"', 'Age', 'True', 'c'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '6', 'What is a for loop commonly used for?', 'To return a value from a function.', 'To execute a block of code indefinitely.', 'To iterate over a sequence of items.', 'To define a conditional statement.', 'c'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '7', 'Which data type is typically used to store whole numbers?', 'String', 'Float', 'Boolean', 'Integer', 'd'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '8', 'What is the purpose of the = operator in most programming languages?', 'To assign a value to a variable.', 'To compare if one value is greater than another.', 'To perform addition.', 'To check if two values are equal.', 'a'),
('ad82b5f1-ebe4-4bf9-81a6-84b402b27836', '9', 'Which of the following is a logical operator?', '+', '>', '-', 'AND', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `course_video`
--

CREATE TABLE `course_video` (
  `Module_num` decimal(2,0) NOT NULL,
  `course_ID` varchar(37) NOT NULL,
  `URL` varchar(100) NOT NULL,
  `Video_num` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_video`
--

INSERT INTO `course_video` (`Module_num`, `course_ID`, `URL`, `Video_num`) VALUES
('1', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/kqtD5dpn9C8?si=Rtbng64GVoYvxRkD', '1'),
('1', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/2dZiMBwX_5Q?si=FnnrJzNsplhLeJnf', '1'),
('1', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/RRubcjpTkks?si=Z9HShT5JVDJjKMjI', '2'),
('1', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/VHbSopMyc4M?si=yeFBPW6LTWoeQnfH', '3'),
('1', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/SQykK40fFds?si=JkZcvQPc87BSiTqi', '4'),
('1', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/Dv7gLpW91DM?si=VqULdBcvSjIEnAf1', '1'),
('1', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://youtu.be/Dv7gLpW91DM?si=VqULdBcvSjIEnAf1', '2'),
('2', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/LKFrQXaoSMQ?si=hFUNfk7y09D08J8z', '1'),
('2', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/sVIvhzEizEQ?si=kZvQB-mbcY_XQaVm', '1'),
('2', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/QnkevG92lqk?si=pnW6EUhb_w3jDsx-', '2'),
('2', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/flWjzwzgybI?si=RzNCGmmEPGqzV4zd', '3'),
('2', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/4ezfRdg6Z7E?si=Sintxji_4Gsfy2T3', '4'),
('2', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/ghCbURMWBD8?si=L03CUNziTwJFavJ3', '1'),
('2', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/ppsCxnNm-JI?si=ync0lMfTQ9oeScMQ', '2'),
('3', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/FvMPfrgGeKs?si=lA2aNfo5O3mjFQKV', '1'),
('3', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/Zp5MuPOtsSY?si=BLbDkLrHgUXLKUK_', '2'),
('3', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/MY03bt_0JQI?si=JdLxIZacX6ver4gy', '1'),
('3', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/HQ3dCWjfRZ4?si=UgB2jpX_agToQ-iQ', '2'),
('3', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/wcwWlasmLWs?si=5nMYh-8j0LhvhWC1', '3'),
('3', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/44VPxJYgtkw?si=HdDiZWQlsUOmuti5', '4'),
('3', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/ppsCxnNm-JI?si=ync0lMfTQ9oeScMQ', '1'),
('3', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://youtu.be/ppsCxnNm-JI?si=ync0lMfTQ9oeScMQ', '2'),
('4', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/x3L-JoYyF8Q?si=fCtGiB3ijHsvVCkB', '1'),
('4', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/DxuPZ_Rz_5Q?si=sxzXDQb8LXVu7ZXg', '1'),
('4', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/uO5nSTJ9Iz4?si=iRfTjZFonQPBcOV7', '2'),
('4', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/eAnXMeX75pM?si=in0AWuE6JK_3AM_K', '1'),
('5', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/_sULQNo9RBo?si=MlOhGm8tCvFfh2wJ', '1'),
('5', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/pTB0EiLXUC8?si=7YYryVkcCBR73G0F', '1'),
('5', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/j0lBrYSlYaU?si=10q51vlkyYv2xfzf', '2'),
('5', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/m_MQYyJpIjg?si=pRVOQdehwBWg_ll3', '3'),
('5', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/eAnXMeX75pM?si=in0AWuE6JK_3AM_K', '1'),
('5', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://youtu.be/eAnXMeX75pM?si=in0AWuE6JK_3AM_K', '2'),
('6', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/R-HLU9Fl5ug?si=VISW6EdyKpvhyr3K', '1'),
('6', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/IUqKuGNasdM?si=ahlJ55o_eFK94ASr', '1'),
('6', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/vjjjGkXpX_I?si=s7hrYg9UMJjOza2x', '2'),
('6', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/3yOLNV9BF8A?si=rV8QEVS9p865I_Bk', '3'),
('6', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/eAnXMeX75pM?si=in0AWuE6JK_3AM_K', '1'),
('6', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://youtu.be/eAnXMeX75pM?si=in0AWuE6JK_3AM_K', '2'),
('7', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', 'https://www.youtube.com/embed/MZZSMaEAC2g?si=A_sMfpflFWHxVcRz', '1'),
('7', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/Wgkb0zg7WOM?si=NC0NDMo6zawZC3Ey', '1'),
('7', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/wAEPokhj5Q4?si=ANQS_kHHzTwaNckg', '2'),
('7', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/adTDlH0lhaA?si=NnsABlN5nBReu12-', '3'),
('7', '964d3651-f24a-40ad-a40c-693e23517ee7', 'https://www.youtube.com/embed/1XAfapkBQjk?si=mXSEKg_2ErChUfnj', '4'),
('7', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://www.youtube.com/embed/eAnXMeX75pM?si=in0AWuE6JK_3AM_K', '1'),
('8', 'ad82b5f1-ebe4-4bf9-81a6-84b402b27836', 'https://youtu.be/eAnXMeX75pM?si=md8AWuE6JK_3AM_K', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_ID`);

--
-- Indexes for table `courses_rejected`
--
ALTER TABLE `courses_rejected`
  ADD PRIMARY KEY (`course_ID`);

--
-- Indexes for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD PRIMARY KEY (`course_ID`,`feedback_giver_ID`);

--
-- Indexes for table `course_modules`
--
ALTER TABLE `course_modules`
  ADD PRIMARY KEY (`course_ID`,`Module_num`);

--
-- Indexes for table `course_registered`
--
ALTER TABLE `course_registered`
  ADD PRIMARY KEY (`course_ID`,`user_ID`);

--
-- Indexes for table `course_scope`
--
ALTER TABLE `course_scope`
  ADD PRIMARY KEY (`course_ID`,`Scope`);

--
-- Indexes for table `course_score`
--
ALTER TABLE `course_score`
  ADD PRIMARY KEY (`course_ID`,`user_ID`,`Attempt_num`);

--
-- Indexes for table `course_test`
--
ALTER TABLE `course_test`
  ADD PRIMARY KEY (`course_ID`,`Question_num`);

--
-- Indexes for table `course_video`
--
ALTER TABLE `course_video`
  ADD PRIMARY KEY (`Module_num`,`course_ID`,`Video_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
