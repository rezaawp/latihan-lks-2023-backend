# API Spec

## Authentication

All API must use this Request Headers

Request : 
* Headers :
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

## Change Password

Request : 
* Method : POST
* Endpoint : `/api/auth/change-password`
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
    "status" : "integer",
    "message" : "string",
    "data" : {
        "new_password" : "string"
    }
}
```

## User
* Request : POST
* Endpoint : `/api/auth/me`

Response (200) : 
```json
{
    "status" : "integer",
    "message" : "string",
    "data" : {
        "user" : {
            "id" : "integer",
            "name" : "string",
            "email" : "string|email",
            "email_verified_at" : null,
            "role" : "string",
            "created_at" : "timestamps",
            "updated_at" : "timestamps"
        }
    }
}
```

## Refresh Token

Request : 
* Method : POST
* Endpoint : `/api/auth/refresh`

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

## Logout

Request : 
* Method : POST
* Endpoint : `/api/auth/logout`

Response (200) :
```json
{
    "status" : "integer",
    "message" : "string",
    "data" : "array|null"
}
```

## Create Polling
Request : 
* Method : POST
* Endpoint : `/v1/api/poll`
* Body : 
```json
{
    "title" : "required, string, min:4",
    "description" : "required, string, min:7",
    "deadline" : "required, date",
    "choises" : "required, array, min:2"
}
```

Response (200 ):
```json
{
    "status" : "integer",
    "message" : "string",
    "data" : {
        "id" : "uuid",
        "title" : "string",
        "description" :  "string",
        "deadline" : "date",
        "user_id" : "integer",
        "choises" : "array"
    }
}
```

## Get All Pollings
Request : 
* Method : GET
* Endpoint : `/v1/api/polls`

Response (200) : 
```json
{
    "status": "integer",
    "message": "string",
    "data": [
        {
          "id": "uuid",
          "title": "string",
          "description": "string",
          "deadline": "date",
          "user_id": "integer",
          "created_at": "timestamps",
          "updated_at": "timestamps"
        }
    ]
}
```

## Get Specific Polling
Request : 
* Method : GET
* Endpoint : `/v1/api/poll/{uuid}`

Response (200) : 
```json
{
  "status": "integer",
  "message": "string",
  "data": {
    "id": "uuid",
    "title": "string",
    "description": "string",
    "deadline": "date",
    "user_id": "integer",
    "created_at": "timestamps",
    "updated_at": "timestamps",
    "choises": [
      {
        "id": "uuid",
        "polling_id": "uuid",
        "choise_name": "string",
        "count": "integer",
        "created_at": "timestamps",
        "updated_at": "timestamps",
        "vote": "object"
      },
      {
        "id": "uuid",
        "polling_id": "uuid",
        "choise_name": "string",
        "count": "integer",
        "created_at": "timestamps",
        "updated_at": "timestamps",
        "vote": "object"
      }
    ]
  }
}
```

## Vote
Request : 
* Method : POST
* Endpoint : `/v1/api/poll/vote`
* Body : 
```json
{
    "choice_uuid" : "uuid",
    "poll_uuid" : "uuid"
}
```
