# Sprint 2 – Web Application Development Project

**Date:** 14 October 2025
**Institution:** Institut La Pineda – CFGS Web Application Development (2DAW ABP)
**Authors:** Olga Domene, Montse Riu, Marcel García
**Review Date:** September 2025

---

## Summary of Tasks

* **Design:** Interface design with Figma for all parts included in this sprint.
* **Login Screen:** Creation of the login page and redirection to the main screen, with access to user role–specific options (some options remain undeveloped).
* **Centre Management:** Creation, modification, and deactivation of centres.
* **Professional Management:** Creation, modification, and deactivation of professionals.
* **Excel Exports:**

  * Assigned lockers list.
  * Uniform size list.
  * Delivered material list (uniform renewal).
* **Entity Management:** Creation, modification, and deactivation of projects and commissions.
* **Annex 3:** JavaScript (integration and architecture).
* **Annex 8:** Use cases for this sprint.
* **Documentation:** Project planning, control, and monitoring documentation.

---

## Objectives

* Plan the creation of a web interface, applying and evaluating design specifications.
* Assess integrated development environments (IDEs) by analyzing their features for editing source code and generating executables.
* Plan and design a database suited to the client’s requirements.
* Create homogeneous web interfaces by defining and applying styles.
* Produce UML diagrams: class diagrams, use case diagrams, and textual descriptions.
* Use events and validate project forms with regular expressions in JavaScript.
* Program PHP scripts using the **Laravel** framework and the **Eloquent ORM** for database access.
* Deploy applications in the cloud and with container technologies.
* Create **unit tests** to test the application.
* Apply **refactoring concepts** to improve project code.
* Plan sprint tasks using **Trello**.
* Manage time effectively and solve problems encountered during development.
* Use **Git** and **GitHub** as version control systems. A commit per workday is mandatory.
* Present the completed work to classmates.
* Maintain collaborative documentation on **Google Drive**, shared with group members (edit mode) and teachers (view mode).

---

## Project Overview

The team has been tasked with creating a **web application for managing a centre for people with dependency**.
Client requirements are detailed in the document *RequerimentsClient.docx*.

---

## Annexes

* **Annex 3:** Selection of JavaScript Architectures and Programming Technologies for Web Clients.
* **Annex 4:** Installation and configuration of the Apache web server.
* **Annex 5:** Installation and configuration of FTP server and client (Proftpd and FileZilla).
* **Annex 6:** Configuration of **Docweaver** to generate and publish the project’s technical documentation in web format.
* **Annex 7:** Interface design created in **Figma**.
* **Annex 8:** UML diagrams (class and use case diagrams with textual descriptions).
* **Annex 9:** Installation of **PHPStorm** and **Visual Studio Code**, including a comparison of their features.

---

## JavaScript Integration

* **Laravel–JavaScript communication:** via embedded JSON.
* **AJAX requests:** implemented with **jQuery AJAX**.
* **Callbacks:** used to process server responses.
* **Form validation:** includes **regular expressions (Regex)**.
* **Event handling:** implemented with JS/jQuery.
* **Object-Oriented Programming:** applied to certain code parts (e.g., Users).
* **Drag and Drop:** used at least for assigning professionals to courses.
* **LocalStorage/sessionStorage:** stores incomplete form data (non-critical) in case a window is closed accidentally (e.g., course lists).

---

## Interface Design

* **Design tool:** Figma.
* **CSS framework:** Tailwind.
* **Responsive design:** implemented with media queries.
* **Canvas integration:** provides a collaborative space for users to create quick diagrams or sketches.
* **SVG sprites:** used to group all icons into a single file.

---

## Backend

* Backend developed using **Laravel**.
* Database creation handled through **Laravel migrations**.
* Database managed with **MySQL**.
* Data queries executed using **Laravel Eloquent ORM**.
