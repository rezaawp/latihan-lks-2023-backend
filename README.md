# API Spec

## Authentication

All API must use this Request Headers

Request : 
* Header :
    - Authorization : Bearer token
    - Content-Type : application/json
    - Accept : application/json

## Register

Request :
* Method : POST
* Endpoint : `/api/auth/register`
* Body :
```json
{
    "name" : "required, string, min:4",
    "email" : "required, email",
    "possword" : "min:8",
    "role" : "required, enum('admin', 'user')"
}
```

Response (200) :
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

## Login

Request : 
* Method : POST
* Endpoint : `/api/auth/login`
* Body :
```json
{
    "email" : "string|email",
    "password" : "string,min:8"
}
```

Response (200) :
```json
{
    "status" : "integer",
    "message" : "string",
    "data" : {
        "access_token" : "string",
        "token_type" : "string",
        "expired" : "integer"
    }
}
```

## Forgot Password

Request : 
* Method : POST
* Endpoint : /api/auth/reset-password
* Body : 
```json
{
    "old_password" : "required, min:8",
    "new_password" : "required, min:8"
}
```

Response (200) :
```json
{
    "status" : "integer"
}
```

