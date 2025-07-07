# osTicket Docker Setup

This directory contains the Docker configuration for setting up osTicket with OAuth2 integration.

## Overview

The Dockerfile sets up osTicket, an open-source support ticket system, with the following features:
- PHP 8.2 with Apache
- OAuth2 authentication plugin
- Required PHP extensions and dependencies

## Prerequisites

- Docker
- Docker Compose (if using docker-compose.yml)
- Git

## Components

The setup includes:
1. Base PHP 8.2 Apache image
2. Required system dependencies
3. PHP extensions (intl, xml, gd, mysqli, zip, opcache)
4. osTicket core installation
5. OAuth2 plugin

## Building the Image

To build the Docker image:

```bash
docker build -t osticket:latest .
```

## Configuration

The setup requires configuration of the following:

1. osTicket configuration file (`ost-config.php`)
2. OAuth2 plugin settings

**Note:** The `ost-config.php` file is now taken from the `upload` folder instead of the `include` folder. Please ensure you place or mount your configuration file at `/var/www/html/upload/ost-config.php`.

## Usage

### Running the Container

```bash
docker run -d \
  -p 80:80 \
  -v osticket-data:/var/www/html/upload \
  --name osticket \
  osticket:latest
```

## Directory Structure

```
/var/www/html/
├── upload/
│   ├── ost-config.php
│   └── ... (other upload files)
├── include/
│   ├── plugins/
│   │   └── auth-oauth2/
└── ... (other osTicket files)
```

## Security Considerations

- The `ost-config.php` file is set to 0666 permissions for initial setup
- After configuration, consider changing the permissions to be more restrictive
- Ensure proper SSL/TLS configuration for production use
- Keep the system and dependencies updated

## Troubleshooting

Common issues and solutions:

1. Permission issues: Ensure proper ownership of files (www-data:www-data)
2. Plugin activation: Check plugin installation in the admin panel
3. OAuth2 configuration: Verify settings in the plugin configuration
4. Configuration file location: Make sure `ost-config.php` is present in the `upload` folder, not `include`.

## License

This setup is based on osTicket which is released under the GPL v2 license. 