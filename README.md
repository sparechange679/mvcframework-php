# MVC Framework in PHP

Using pure simple PHP to create a basic MVC Framework

## Overview

This project is a lightweight Model-View-Controller (MVC) framework built from scratch in pure PHP and Bootstrap for the front-end. It is designed to help you understand the core principles of the MVC architecture and how to implement them without relying on heavy external libraries or frameworks.

## Features

- Pure PHP implementation (no dependencies)
- Simple routing system
- Basic Controller, Model, and View structure
- Easily extendable for your own needs
- Uses Bootstrap for front-end

## Getting Started

### Prerequisites

- PHP 7.0 or higher
- A web server (e.g., Apache or Nginx)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/sparechange679/mvcframework-php.git
   cd mvcframework-php
   ```

2. Start your web server in my case Wamp Server save the folder in Wamp/www/.

3. Start your server and visit your project in the browser `http://localhost/mvcframework-php/`.

### Directory Structure

```
mvcframework-php/
├── assets/
  ├── css/
    |── bootstrap.min.css
  ├── js/
    |── bootstrap.bundle.min.js
    |── jquery.min.js
├── controllers/
  |── auth.php
  |── tweets.php
├── database/
  |── tweets-12.sql
├── views/
  ├── partials/
    |── footer.php
    |── head.php
    |── modal-auth.php
    |── nav.php
  |── 404.php
  |── home.php
  |── public-profiles.php
  |── search.php
  |── your-tweets.php
├── .gitattributes
├── config.php
├── functions.php
├── index.php       # Home starting file
├── LICENSE
├── README.md
├── setup.php.php
```

## Usage

1. Add your controllers to the `controllers` directory.
2. Add your models to the `database` directory.
3. Add your views to the `views` directory.
4. Update routes as needed in the config file.

## Contributing

Contributions are welcome! Please open issues or pull requests to discuss improvements or report bugs.

## License

[MIT License](LICENSE)

---

Feel free to customize and expand this README to fit your project’s specific structure and features!