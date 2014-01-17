# Documentation


--- USERS CRUD BASIC ---

1 - GET all users
``` 
http://localhost/api/v1/
```

2 - GET an user
```
http://localhost/api/v1/users/1
```

3 - POST an user
```
http://localhost/api/v1/users/
```
- email
- pass

4 - PUT an user
```
http://localhost/api/v1/users/
```
- email
- pass

5 - DELETE an user
```
http://localhost/api/v1/users/1
```

--- MOVIES CRUD BASIC ---

6 - GET all movies
```
http://localhost/api/v1/movies
```

7 - GET a movie
```
http://localhost/api/v1/movies/1
```

8 - POST a movie
http://localhost/api/v1/movies/
- name
- author
- realisator

4 - PUT a movie
```
http://localhost/api/v1/movies/
```
- name
- author
- realisator

5 - DELETE a movie
```
http://localhost/api/v1/movies/1
```


--- MOVIES LIKED CRUD ---

6 - GET all movies liked
```
http://localhost/api/v1/mymovies/liked
```

7 - GET a movie liked by an user
```
http://localhost/api/v1/mymovies/liked/1
```

8 - POST a movie liked by an user
```
http://localhost/api/v1/mymovies/liked/
```

9 - POST a movie liked to unliked by an user (update)
```
http://localhost/api/v1/mymovies/like
```


--- MOVIES SEEN CRUD ---

10 - GET all movies seen
```
http://localhost/api/v1/mymovies/seen
```

11 - GET a movie seen by an user
```
http://localhost/api/v1/mymovies/seen/1
```

12 - POST a movie seen by an user
```
http://localhost/api/v1/mymovies/seen/
```

13 - POST a movie seen to unseen by an user (update)
```
http://localhost/api/v1/mymovies/seen/
```


--- MOVIES WOULD SEE CRUD ---

14 - GET all movies would see
```
http://localhost/api/v1/mymovies/wouldsee
```

15 - GET a movie would see by an user
```
http://localhost/api/v1/mymovies/wouldsee/1
```

16 - POST a movie would see by an user
```
http://localhost/api/v1/mymovies/wouldsee/
```

17 - POST a movie would see to not would see by an user (update)
```
http://localhost/api/v1/mymovies/wouldsee/
```
