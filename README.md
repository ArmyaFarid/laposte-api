# LaPost API

LaPost API is a PHP Symfony-based application designed for managing imports and exports. The system includes an admin account with the ability to create employee accounts. Employees, in turn, can create and manage import and export operations. Additionally, the system supports generating custom monthly reports for imports and exports, including associated prices.

## Features

- **Admin Account**: Admins can create and manage employee accounts.

- **Employee Account**: Employees can create, manage, and track import/export operations.

- **Monthly Reports**: Generate custom monthly reports for imports and exports, including detailed pricing information.

## Stack Used

- **Backend**: [PHP](https://www.php.net/) with [Symfony](https://symfony.com/)

## Installation

### Prerequisites

- [Composer](https://getcomposer.org/)
- [Symfony CLI](https://symfony.com/download)

### Steps

1. Clone the repository:

    ```bash
    git clone https://github.com/ArmyaFarid/laposte-api
    ```

2. Navigate to the project directory:

    ```bash
    cd lapost-api
    ```

3. Install dependencies:

    ```bash
    composer install
    ```

4. Create and migrate the database:

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5. Run the Symfony development server:

    ```bash
    symfony server:start
    ```

7. Test the api at [http://localhost:8000](http://localhost:8000).

## Usage

1. Navigate to the application in your web browser.

2. Log in using your admin credentials.

3. Create employee accounts as needed.

4. Employees can log in, create, and manage import/export operations.

6. Data pagination

7. Generate custom monthly reports with detailed pricing information.

## Contributing

If you'd like to contribute to the development of LaPost API, please follow our [contribution guidelines](CONTRIBUTING.md).

## License

This project is licensed under the [MIT License](LICENSE).

## Support

As LaPost API is currently in development, we do not provide direct support. However, we encourage users to fork the project, make improvements, and adapt it to their specific needs.

Thank you for using LaPost API! We appreciate your interest and contributions to the project.
