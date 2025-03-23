# KRAS Hosting Project

This project is a web application for KRAS Hosting, a company that offers web hosting services to small and medium-sized businesses (SMB). It was developed using the SCRUM methodology.

## Project Structure

### Public Website
- `index.html` - Homepage showcasing the company and hosting packages
- `product.html` - Detailed information about hosting packages with comparison table
- `contact.html` - Contact information and FAQ
- `bestellen.html` - Order form for purchasing hosting packages
- `bedankt.html` - Order confirmation page

### Admin Dashboard
- `dashboard.php` - Secure area for website management
- `login.php` - Login page for administrators
- `register.php` - Registration page for new administrators
- `logout.php` - Logout functionality

### Assets
- `style.css` - Main stylesheet for the website
- `logo.png` - Company logo

### Database
- `kras_hosting.sql` - Database schema with users table

## Features

### Public Website
- Responsive design for all devices
- Detailed hosting package information
- Package comparison table
- Order forms for each hosting package
- Contact information and FAQ

### Admin Dashboard
- Secure login system
- Content management for the website
- Package management (price, features)
- News management for homepage

## Installation Instructions

1. Set up a local web server with PHP and MySQL (e.g., XAMPP, WAMP, or MAMP)
2. Import the `kras_hosting.sql` file into your MySQL database
3. Place all files in your web server's document root
4. Access the website through your local server (e.g., http://localhost)

## Login Information
- Email: r@gmail.com
- Password: The password is hashed in the database. For testing purposes, create a new account using the registration page.

## Development Notes

### SCRUM Methodology
This project follows the SCRUM development methodology with:
- Product Owner: The instructor
- Development Team: The students
- Scrum Master: One of the team members

### Project Structure
- The website is built with HTML, CSS, PHP, and JavaScript
- The database uses MySQL for user management
- The login system uses PHP sessions for authentication

### Future Enhancements
- Implement actual package purchasing functionality
- Add payment processing integration
- Create a user dashboard for customers
- Implement a content management system for all website content

## Credits
- KRAS Hosting Project - Web2 Course
- Developed by: [Your Team Name/Number]
- Year: 2025

## License
All rights reserved. This project is part of an educational assignment.