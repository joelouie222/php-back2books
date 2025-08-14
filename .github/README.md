# 📚 Back2Books 
A PHP-based implementation of the Back2Books project — a retro/Y2K-style online bookstore built for CS 3773 Software Engineering at the University of Texas at San Antonio.

<!-- PROJECT LOGO (1098x283) -->  
<a href="https://back2books-demo.azurewebsites.net/" target="_blank"><img src="../images/b2b-logo-header.png" alt="Logo" width="549" height="141.5"></a>

## 📖 Table of Contents
- [Project Overview](#project-overview)
- [Architecture](#architecture)
- [Features](#features)
  - [Customer-Facing](#customer-facing)
  - [Administrative Panel](#administrative-panel)
- [Future Development](#future-development)
- [Live Demo](#live-demo)
- [Team](#team)
- [Project Requirements Status](#project-requirements-status)
- [Technologies Used](#technologies-used)
- [Design Artifacts](#design-artifacts)


## 📝 Project Overview

**Back2Books** is a database-driven web application developed as a class project for the CS 3773 Software Engineering course at the University of Texas at San Antonio. Written primarily in PHP, at its core, the project is a three-tier web application that currently functions as a centralized online bookstore. The website acts as the sole seller, managing a catalog of used textbooks that users can browse and purchase.

The project was built by a five-person student team ("Team 9: Operation B2B") and serves as a practical demonstration of applying software engineering principles—from initial design and project management to development and deployment. The long-term vision for the project is to evolve it from its current single-seller model into a dynamic, peer-to-peer marketplace where users can buy and sell textbooks directly from one another.

    Project Requirements: Develop an application that satisfy the the following
    - Database driven
    - Create/Modify User Information
        - Allow users to register for accounts
    - Create/Modify Items for Sale
        - Include images
        - Include price
        - Include quantity available
        - Allow ability to add new items
    - Create/Modify Shopping Cart
        - Show items in cart
        - Calculate taxes: assume 8.25% tax rate
        - Allow for discount codes
        - Show summary of order and allow for order to be placed
    - Ability to search based on criteria:
        - Item/Description
        - Sort by Price
        - Sort by Availability
    - Administrative back end
        - Allow to modify all items
        - Allow for creation of discount codes
        - Allow for creation of sales items
        - Allow to modify users
        - Show currently placed orders
        - Show history of orders
            - Sort by order date
            - Sort by customer
            - Sort by order size in dollar amount
    - Intuitive UI/UX
    - Deployed as a web application (bonus)

## 🧱 Architecture

The application is built on a classic three-tier architecture, featuring a user-facing frontend, a PHP backend that handles all business logic, and a robust Azure SQL Database. The database schema is well-designed and normalized.

- **Frontend**: HTML/CSS/JavaScript
- **Backend**: PHP for business logic and session management
- **Database**: Azure SQL with normalized schema

## 🚀 Features

### 👤 Customer-Facing

- **Account Management**
  - Secure registration and login
  - Shopping cart auto-created on signup

- **Product Discovery**
  - Homepage with carousel and search bar
  - Catalog with sorting by price and availability
  - Advanced search with relevance-based results
  - Detailed product pages

- **E-commerce Workflow**
  - Persistent shopping cart
  - Discount code engine
  - Checkout with tax (8.25%) and shipping
  - Order placement with inventory updates
  - Order history with sorting options

### ⚙️ Administrative Panel

- **Accessible only to admin users**
    - Product management with multi-table transactions
    - User management (CRUD)
    - Order management and editing
    - Promotion creation and tracking

## 🔜 Future Development (Road Map)

### 🧑‍🤝‍🧑 Peer-to-Peer Marketplace
- User listings with image uploads and pricing
- Public profiles with transaction histor

### 💳 Transactions & Communication

- Stripe/PayPal integration
- In-app messaging between buyers and sellers

### ⭐ Trust & Usability
- Ratings and reviews
- Advanced search filters (condition, price, location)

### 🛡️ Admin Enhancements
- Marketplace oversight and dispute resolution
- Analytics dashboard

### 🔔 Notifications
- Email and in-app alerts for key events

## 🌍 Live Demo

You can explore the deployed version of Back2Books here:  
🔗 [https://back2books-demo.azurewebsites.net/](https://back2books-demo.azurewebsites.net/)

> Note: This is a demo version hosted on Microsoft Azure. Some features may be limited or under development.


## 👥 Team 9: Operation B2B

| Member | Role |
|--------|------|
| [Kip Roberts-Lemus](https://github.com/kip-is-tired) | Product Owner |
| [Bernardo Vazquez De La Cruz](https://github.com/Ber-Vazq) | Scrum Master |
| [Andrea Mendez](https://github.com/andreasroses) | Developer |
| [Daniel Hwang](https://github.com/nielmin) | Developer |
| [Joe Louie Corporal](https://github.com/joelouie222) | Developer |

Instructor: [Ali Dogru](mailto:alihikmet.dogru@utsa.edu)

---

## ✅ Project Requirements Status

| Requirement | Status | Notes |
|-------------|--------|-------|
| Database Driven | ✅ | Fully dynamic via Azure SQL |
| User Registration | ✅ | Validated form + cart creation |
| Modify User Info | ⚠️ Partial | Admins only; user profile editing planned |
| Create/Modify Items | ⚠️ Partial | Add implemented; edit/delete planned |
| Include Images, Price, Quantity | ✅ | Displayed in catalog/product pages |
| Add New Items | ✅ | Transactional multi-table insert |
| Shopping Cart | ✅ | Persistent, editable cart |
| Tax Calculation | ✅ | 8.25% tax applied |
| Discount Codes | ✅ | Admin-managed, user-applied |
| Order Summary & Placement | ✅ | Full checkout flow with inventory updates |
| Search by Item/Description | ✅ | Advanced search logic |
| Sort by Price & Availability | ✅ | Dropdown filters |
| Admin Backend | ⚠️ Partial | Add/view implemented; edit/delete planned |
| View Orders & History | ✅ | Admin and user views |
| Sort Orders | ✅ | By date, customer, and value |
| Intuitive UI/UX | ✅ | Clean layout and navigation |
| Web Application | ✅ | Hosted on Azure, built with PHP |

---

## 🧰 Technologies Used

### 🌐 Frontend

| Technology | Purpose |
|------------|---------|
| [![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML) | Page structure |
| [![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS) | Styling and layout |
| [![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript) | Client-side interactivity |

### 🖥️ Backend

| Technology | Purpose |
|------------|---------|
| [![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/) | Server-side logic and session handling |

### 🗄️ Database

| Technology | Purpose |
|------------|---------|
| [![Microsoft SQL Server](https://img.shields.io/badge/Microsoft%20SQL%20Server-CC2927?style=for-the-badge&logo=microsoft%20sql%20server&logoColor=white)](https://www.microsoft.com/en-us/sql-server) | Relational data storage |

### 🛠️ Development & Deployment

| Technology | Purpose |
|------------|---------|
| [![VS Code](https://img.shields.io/badge/VS%20Code-007ACC?style=for-the-badge&logo=visualstudiocode&logoColor=white)](https://code.visualstudio.com/) | Code editor |
| [![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/) | Version control |
| [![GitHub Actions](https://img.shields.io/badge/GitHub%20Actions-2088FF?style=for-the-badge&logo=githubactions&logoColor=white)](https://github.com/features/actions) | CI/CD automation |
| [![Azure](https://img.shields.io/badge/Microsoft%20Azure-0078D4?style=for-the-badge&logo=microsoftazure&logoColor=white)](https://azure.microsoft.com/) | Cloud hosting |

### 🎨 Design & Planning

| Technology | Purpose |
|------------|---------|
| [![Figma](https://img.shields.io/badge/Figma-F24E1E?style=for-the-badge&logo=figma&logoColor=white)](https://www.figma.com/) | UI wireframes |
| [![Lucid](https://img.shields.io/badge/Lucid-4B4B4B?style=for-the-badge&logo=lucid&logoColor=white)](https://lucid.co/) | UML diagrams |
| [![Trello](https://img.shields.io/badge/Trello-0052CC?style=for-the-badge&logo=trello&logoColor=white)](https://trello.com/) | Task management |



## 🧩 Design Artifacts

- 📊 [Lucidchart UML Design](https://lucid.app/lucidchart/invitations/accept/inv_5f1aa998-0f6d-45c3-b788-fbce3e6d0cd3)


- 🖼️ [Google Drive Wireframe Folder](https://drive.google.com/drive/folders/1vGtIzw8nxCOGdjlfECfqK5tEcCy9Dy1C)


- 🎨 [Figma Wireframe](https://www.figma.com/file/3CZV9JxNnTz4GMnEIf0u3d/Back2Books-Wireframe?type=design&node-id=0%3A1&mode=design&t=ZYBhj8Wr3YwOL20S-1)

<br />


Made with ❤️ by Team 9: Operation B2B <br/>
[![Live Site](https://img.shields.io/badge/Live%20Site-Back2Books-blue?style=flat-square)](https://back2books-demo.azurewebsites.net/) 