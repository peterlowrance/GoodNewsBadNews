# GoodNewsBadNews
GoodNewsBadNews allows users to view news articles based on their whether their tone is happy or sad. 

## Installation
The GoodNewsBadNews must be run under XAMPP in order for the user to have full functionality within the website.

In addition, the user must import the provided users.sql file into phpMyAdmin with a database named "happysadnews" to take advantage of the login, create account, and user page features.
 
## API Reference
The news articles displayed are pulled from News API (https://newsapi.org/).

The IBM Watson Tone Analyzer API is used to determine the sentiment level for each article (https://tone-analyzer-demo.ng.bluemix.net/).

## Requirements yet to complete
- Logged in user should be able to save articles which they can view later
- Logged in user should be able to view their saved articles in their profile
- Logged in user should be able to remove saved articles in their profile