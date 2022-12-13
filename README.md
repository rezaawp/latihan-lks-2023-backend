Request :
```json
{
    "name": "required, string, min:4",
    "email": "required, email",
    "possword": "min:8",
    "role": "required, enum('admin', 'user')
}
```

Response :
```json
{
    "status": "integer",
    "message": "string",
    "data": {
        "name": "string",
        "email": "string|email",
        "password": null,
        "role": "string"
    }
}
```
