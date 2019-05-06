# MY TODOS
My Todos is a responsive application for managing tasks and deadlines. It can be used on desktops, tablets and mobile phones. When user enters the application, it first requires either to log in if registration has been done already or to register a new account. After logging in it is possible to start using the application. If task list is empty, application shows a little instruction of how to get started. 

It is possible to add new tasks to the list (plus icon), mark them as done (checked icon), edit them (pen icon) or delete them (trash icon). These actions can be executed by clicking/touching these icons in the “Tools” section. When adding or editing tasks, there must be set task description, deadline and priority level. In the task list it is possible to sort deadline (from the earliest date to the latest) or priority (from the highest level to the lowest), but at this point this feature is still under construction, so not able to do it vice versa or combine these two sortings. 

If user wants to logout, it can be done by clicking/touching the logout icon in the right upper corner and application directs user back to the login page.

Instructions for implementation:

1.	You need to have XAMPP (or similar) installed and then start Apache and MySQL
2.	Download this project to your computer and put it in a new file “mytodos” in \XAMMP\htdocs\ folder
3.	For creating database structure, you will need todolist.sql (located in SQL file)
4.	Note: if you insert data from testdata.sql use these credentials in application when logging in: username jon@test.com and password jonsnow1
5.	Open MySQL Admin from XAMPP, create a database named “todolist” and import todolist.sql there
6.	Remember to change and save these credentials in DBconn.php – file: $servername = "localhost", $username = "root", $password = "" and $dbname = "todolist"
7.	Type localhost/mytodos/index.php into your browser’s URL
8.	My Todos should be now up and running!
 
**Important!** If hosted in publicly (in Azure or similar) it is not recommended to use any real names, emails or other personal information due to security reasons. 
