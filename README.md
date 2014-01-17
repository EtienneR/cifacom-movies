## Documentation


--- USERS CRUD BASIC ---

### 1 - GET all users
``` 
http://localhost/api/v1/
```

### 2 - GET an user
```
http://localhost/api/v1/users/1
```

### 3 - POST an user
```
http://localhost/api/v1/users/?token=pass
```
- email
- pass

### 4 - PUT an user
```
http://localhost/api/v1/users/?token=pass
```
- email
- pass

### 5 - DELETE an user
```
http://localhost/api/v1/users/1?token=pass
```

--- MOVIES CRUD BASIC ---

### 6 - GET all movies
```
http://localhost/api/v1/movies
```

### 7 - GET a movie
```
http://localhost/api/v1/movies/1
```

### 8 - POST a movie
http://localhost/api/v1/movies/?token=pass
- name
- author
- date

### 9 - PUT a movie
```
http://localhost/api/v1/movies/?token=pass
```
- name
- author
- date

### 10 - DELETE a movie
```
http://localhost/api/v1/movies/1?token=pass
```


--- MOVIES LIKED CRUD ---

### 11 - GET all movies liked
```
http://localhost/api/v1/mymovies/liked
```

### 12 - GET a movie liked by an user
```
http://localhost/api/v1/mymovies/liked/1
```

### 13 - POST a movie liked by an user
```
http://localhost/api/v1/mymovies/liked/?token=pass
```

### 14 - POST a movie liked to unliked by an user (update)
```
http://localhost/api/v1/mymovies/like?token=pass
```


--- MOVIES SEEN CRUD ---

### 15 - GET all movies seen
```
http://localhost/api/v1/mymovies/seen
```

### 16 - GET a movie seen by an user
```
http://localhost/api/v1/mymovies/seen/1
```

### 17 - POST a movie seen by an user
```
http://localhost/api/v1/mymovies/seen/?token=pass
```

### 18 - POST a movie seen to unseen by an user (update)
```
http://localhost/api/v1/mymovies/seen/?token=pass
```


--- MOVIES WOULD SEE CRUD ---

### 19 - GET all movies would see
```
http://localhost/api/v1/mymovies/wouldsee
```

### 20 - GET a movie would see by an user
```
http://localhost/api/v1/mymovies/wouldsee/1
```

### 21 - POST a movie would see by an user
```
http://localhost/api/v1/mymovies/wouldsee/?token=pass
```

### 22 - POST a movie would see to not would see by an user (update)
```
http://localhost/api/v1/mymovies/wouldsee/?token=pass
```
