# mojazapp-task
An API application requested as a task from MojazApp team.

---

# Setup the dev server

To run the development server on your machine,
1. Navigate to the local repo on your machine using:

```bash
  $ cd /path/to/repo/
```

2. Run the following command:

```bash
  $ php artisan serve
```

---

# How to use

Send a POST request with the appropriate fields to the appropriate URI.

## Here is a list of all available URIs

1. `/api/register`
  This URI is used to register a new user. It requires 3 query parameters:
    - username
    - password
    - email
    
    ### General URI
    `[host]:[port]/api/register?username=[username]&password=[password]&email=[email]`
    
    ### Example URI
    `http://127.0.0.1:8000/api/register?username=michael&password=senshi&email=senshi%40senshi.com`

---

2. `/api/login`
  This URI is used to log an existing user in. It requires 2 query parameters:
    - username
    - password
    
    ### General URI
    `[host]:[port]/api/login?username=[username]&password=[password]`
    
   ### Example URI
   `http://127.0.0.1:8000/api/login?username=michael&password=senshi`

---

3. `/api/logout`
  This URI is used to logout a logged in user. `Requires logging in first`. It requires no (0) query parameters:
    
    ### General URI
    `[host]:[port]/api/logout`
    
   ### Example URI
   `http://127.0.0.1:8000/api/logout`

---

4. `/api/list`
  This URI sends a json of all the logged in user's lists. `Requires logging in first`. It requires no (0) query parameters:
    
    ### General URI
    `[host]:[port]/api/list`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list`

---

5. `/api/list/create`
  This URI is used to create a new list. `Requires logging in first`. It requires 1 query parameter:
     - title
    
    ### General URI
    `[host]:[port]/api/list/create?title=[title]`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/create?title=my%20first%20list`

---

6. `/api/list/[list_id]`
  This URI returns a json with a specific list details. `Requires logging in first`. It requires 1 URL parameter:
     - list_id
    
    ### General URI
    `[host]:[port]/api/list/[list_id]`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/5`

---

7. `/api/list/[list_id]/edit`
  This URI edits a specific list title. `Requires logging in first`. It requires 1 URL parameter and 1 query parameter:
     - URL parameter -> list_id
     - Query parameter -> title
     
    
    ### General URI
    `[host]:[port]/api/list/[list_id]/edit`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/5/edit?title=my%20second%20edited%20list`

---

8. `/api/list/[list_id]/delete`
  This URI deletes a specific list. `Requires logging in first`. It requires 1 URL parameter:
     - list_id
    
    ### General URI
    `[host]:[port]/api/list/[list_id]/delete`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/5/delete`

---

9. `/api/list/[list_id]/item`
  This URI adds an item to a specific list. `Requires logging in first`. It requires 1 URL parameter and 1 query parameter:
     - URL parameter -> list_id
     - Query parameter -> body
    
    ### General URI
    `[host]:[port]/api/list/[list_id]/item?body=[body]`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/5/item?body=my%20first%20item`

---

10. `/api/list/[list_id]/item/[item_id]`
  This URI returns a json of a specific item that belongs to a specific list. `Requires logging in first`. It requires 2 URL parameters:
     - list_id
     - item_id
    
    ### General URI
    `[host]:[port]/api/list/[list_id]/item/[item_id]`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/5/item/8`

---

11. `/api/list/[list_id]/item/[item_id]/edit`
  This URI edits a specific item that belongs to a specific list. `Requires logging in first`. It requires 2 URL parameters and 1 query parameter:
     - URL parameter 1 -> list_id
     - URL parameter 2 -> item_id
     - Query parameter -> body
    
    ### General URI
    `[host]:[port]/api/list/[list_id]/item/[item_id]/edit?body=[body]`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/5/item/8/edit?body=my%20first%20edited%20item`

---

12. `/api/list/[list_id]/item/[item_id]/delete`
  This URI deletes a specific item that belongs to a specific list. `Requires logging in first`. It requires 2 URL parameters:
     - list_id
     - item_id
    
    ### General URI
    `[host]:[port]/api/list/[list_id]/item/[item_id]/delete`
    
   ### Example URI
   `http://127.0.0.1:8000/api/list/5/item/8/delete`

---

Tested with [Insomnia REST Client](https://insomnia.rest/)
