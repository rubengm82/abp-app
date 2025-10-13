# Database Configuration

## AlwaysData MySQL Server

- **Hostname**: mysql-rubengmpineda.alwaysdata.net
- **IP Address**: 185.31.40.34
- **Database**: rubengmpineda_abp
- **Username**: 431396_abp
- **Port**: 3306

## Troubleshooting

Si hay problemas de conexión DNS con el hostname, usar la IP directa en el archivo `.env`:

```env
DB_HOST=185.31.40.34
```

## Connection Details

- Provider: AlwaysData
- Service: MySQL Database
- Last verified: 2024-01-13
- Status: Working with IP address

## Configuration Files

- `.env`: Main configuration file
- `.env.backup`: Backup configuration with IP address
- `config/database.php`: Laravel database configuration

## Common Issues

1. **DNS Resolution Error**: `Name or service not known`
   - **Solution**: Use IP address `185.31.40.34` instead of hostname

2. **Connection Timeout**: 
   - **Solution**: Verify IP address is correct and server is accessible

3. **Authentication Failed**:
   - **Solution**: Check username and password in `.env` file

## Testing Connection

```bash
# Test database connection
php artisan migrate:status

# Test with specific command
php artisan tinker
>>> DB::connection()->getPdo();
```
