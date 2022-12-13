# Register

The background color should be `#ffffff` for light mode and `#0d1117` 

Request :
* Method : POST
* Endpoint : /api/auth/register
* Header :
  - Content-Type : application/json
  - Accept : application/json
* Body :
```json
{
    "name" : "required, string, min:4",
    "email" : "required, email",
    "possword" : "min:8",
    "role" : "required, enum('admin', 'user')"
}
```

Response :
```json
{
    "status" : "integer",
    "message" : "string",
    "data" : {
        "name" : "string",
        "email" : "string|email",
        "password" : null,
        "role" : "string"
    }
}
```
