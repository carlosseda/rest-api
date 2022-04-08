## Install application

1. Clone repository and setup.<br>
`sudo git clone git@github.com:nicp0nim/rest-api.git`<br>
`cd rest-api`<br>
`sudo cp .env.example .env`<br>
2. Start docker.<br>
`sudo docker-compose up -d`
3. Install needed packages.<br>
`sudo docker exec php-fpm composer install`<br>
4. Migrate, install passport and seed database with fake data.<br>
`sudo docker exec php-fpm php artisan key:generate`<br>
`sudo docker exec php-fpm php artisan migrate:fresh --seed`<br>
`sudo docker exec php-fpm php artisan passport:install`<br>

## API Endpoints and Routes

```
+-----------+----------------------------+-----------------+--------------------------------------------------+--------------+
| Method    | URI                        | Name            | Action                                           | Middleware   |
+-----------+----------------------------+-----------------+--------------------------------------------------+--------------+
| GET|HEAD  | /                          |                 | Closure                                          | web          |
+-----------+----------------------------+-----------------+--------------------------------------------------+--------------+
| GET|HEAD  | api/clients                | clients.index   | App\Http\Controllers\ClientController@index      | api,auth:api |
| POST      | api/clients                | clients.store   | App\Http\Controllers\ClientController@store      | api,auth:api |
| DELETE    | api/clients/{client}       | clients.destroy | App\Http\Controllers\ClientController@destroy    | api,auth:api |
| PUT|PATCH | api/clients/{client}       | clients.update  | App\Http\Controllers\ClientController@update     | api,auth:api |
| GET|HEAD  | api/clients/{client}       | clients.show    | App\Http\Controllers\ClientController@show       | api,auth:api |
+-----------+----------------------------+-----------------+--------------------------------------------------+--------------+
| GET|HEAD  | api/roles                  | roles.index     | App\Http\Controllers\RoleController@index        | api,auth:api |
| POST      | api/roles                  | roles.store     | App\Http\Controllers\RoleController@store        | api,auth:api |
| DELETE    | api/roles/{client}         | roles.destroy   | App\Http\Controllers\RoleController@destroy      | api,auth:api |
| PUT|PATCH | api/roles/{client}         | roles.update    | App\Http\Controllers\RoleController@update       | api,auth:api |
| GET|HEAD  | api/roles/{client}         | roles.show      | App\Http\Controllers\RoleController@show         | api,auth:api |
+-----------+----------------------------+-----------------+--------------------------------------------------+--------------+
| GET|HEAD  | api/users                  | users.index     | App\Http\Controllers\UserController@index        | api,auth:api |
| POST      | api/users                  | users.store     | App\Http\Controllers\UserController@store        | api,auth:api |
| DELETE    | api/users/{client}         | users.destroy   | App\Http\Controllers\UserController@destroy      | api,auth:api |
| PUT|PATCH | api/users/{client}         | users.update    | App\Http\Controllers\UserController@update       | api,auth:api |
| GET|HEAD  | api/users/{client}         | users.show      | App\Http\Controllers\UserController@show         | api,auth:api |
+-----------+----------------------------+-----------------+--------------------------------------------------+--------------+
| POST      | api/login                  | auth.login      | App\Http\Controllers\AuthController@login        | api          |
| GET|HEAD  | api/logout                 | auth.logout     | App\Http\Controllers\AuthController@logout       | api,auth:api |
| GET|HEAD  | api/profile                | auth.profile    | App\Http\Controllers\AuthController@profile      | api,auth:api |
| POST      | api/register               | auth.register   | App\Http\Controllers\AuthController@register     | api          |
+-----------+----------------------------+-----------------+--------------------------------------------------+--------------+
```

#### Example login request

```bash
curl --location --request POST "http://localhost:8080/api/login" \
  --header "Content-Type: application/json" \
  --header "X-Requested-With: XMLHttpRequest" \
  --data "{
	\"email\": \"admin@mail.com\",
	\"password\": \"pass\"
}"
```

#### Example login response

```json
{
  "success": true,
  "data": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1ZmUyOGI4NTFmM2I1Mjc0MGVkNjFlYzM4ZDgyZmQ2M2ZhYmY1NDM5NjI0ZDZlZDViODAwZDFkMDU2MjBiNjdlYzE3MDNjYzU3MzYwNTcxIn0.eyJhdWQiOiIxIiwianRpIjoiMTVmZTI4Yjg1MWYzYjUyNzQwZWQ2MWVjMzhkODJmZDYzZmFiZjU0Mzk2MjRkNmVkNWI4MDBkMWQwNTYyMGI2N2VjMTcwM2NjNTczNjA1NzEiLCJpYXQiOjE1NjYyNjI5NzEsIm5iZiI6MTU2NjI2Mjk3MSwiZXhwIjoxNTk3ODg1MzcxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.aUBUPQDpiHLYR7-ZQHttYPe59ubTBxGgOs8WktDxqv5nlG4WqMIOtfARpdt56NTkD9SrEH1Xo9MaCCLswif25y3xNObHl5MM_X7j1nXE59kHmQt0waqIHq1yCLzVuBtbGkuflZQY4QfM59SKDikGmPNvH98uZjz2wxuah7FF8c5oADxjcBVAuZKfJaewwPSh49qck0dgB-IOpiJ38ihaYiMZCh1DTZJwbot2Pzfs54q9QY2S5_CzBv5z56z4-eb4ylkIn7PtaxcjzZnCWK8f8nxYFQHuKd6awyv6bHK6c3MzFjcXQ1Zl9oUUHvrRV-9qIzv6Ot73amVKitDafOXmaC6_oG-bURcl8wVOMVi9GSkrc2j6ZjljDs2w83YhNtglT9Fy10CoDMUBh6HwaLejjwv91dTRhUQ91CoCRtoFCIp7Pq2OG5bM3cNDCUjsn72gCEG_u4WJ_aK8zIx7tmhmfU-nvtctEFoMSSJJ1NYeE0W53jahFeTVVSEd7yJEgk53mlSNgKUw3Q2XfonV6bW-iD2BPd_XCGobh9uIPt5PQdoGZUDP75-njkPIYqUELvSR1n3pUJwLx4smBK-rgzk8TR7LShG2P5gH1AP6qAtrs0ufwHH_3-JL5U5tlGAt7_t3x23opnX-I63KFwD5OhJl_39ran3B91xUwD8y2m-6VQ0"
}
```

#### Example authorized request with token

```bash
curl --location --request GET "http://localhost:8080/api/profile" \
  --header "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM1ZjQ5NTU1N2QzYmEyNjM5OTQzYmQzY2JlMTU1MTI0NmIyZmJiMzc4NGY2ZTJmNTgwOGZlM2Y3YjNiMGM0ZjlkZTM2MzY2ZGNkZTFhOWJjIn0.eyJhdWQiOiIxIiwianRpIjoiMzVmNDk1NTU3ZDNiYTI2Mzk5NDNiZDNjYmUxNTUxMjQ2YjJmYmIzNzg0ZjZlMmY1ODA4ZmUzZjdiM2IwYzRmOWRlMzYzNjZkY2RlMWE5YmMiLCJpYXQiOjE1NjYyNjQ2NjksIm5iZiI6MTU2NjI2NDY2OSwiZXhwIjoxNTk3ODg3MDY5LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.Xf7HGFczhfbXNMtycA3k9O-0FYYkH4Oj-LLJQm4P5br5DwJOf0ScQ0Gb5wKA2k6T1QuYNy6D4h_wGzCUICuvmFHyQ0pTlkUL_2RjefjHy1mIuTPCUkgxFVjAn0qUIBgakrb_I2OXGgRZlO_00eyYRiSaMBtcuEkRljVpJG8EL8JDdTFFEqgoSXrGDfQqubBEW0_IjDw33NXrFVtK-aJQdkTpGNUwr0aSVMT_GcX7u7vJjvCa3Jc50unGXZI6VDpwxsvndAyuuvu8AbRhmN7TNJhCNynT55m4X0ZY9xLH_WAEoT7uI5ei5DdBAfH1_Ux0nJxHLFGaXI15N_OAw8noVgPSPps8Bbn9fsWu7ZqGvj-2gUupVrWS1FVk5qBYzKnV4Osdsl0pRjVfY9yghIRTCGonxCU_A2Fl-i8OUVPUl6iqGxiko2KBo8qqLWQbT3IkUXyB578DAIqgqfZ9gr122B0J5ukyIYtLLHKo0HqYc9NjB2K11ntfB6SPXJBEY6Xrts8xm_0uT1fJ2pIXuvICtC-cUBDioUZ842ijeOJm4h_vESzsqJXQ4Xp32PCvcjHxO9X9EJe5JnDdHD5nlVDeEl4ZtpBZ4zZeef3yXsdMPxwGGiTrwNMZyLHnzWdiNAhZfo13Pk4z9XswDK8omIdtKuEPAIQXT2Z9Gu4keVaI0fQ" \
  --header "Content-Type: application/json" \
  --header "X-Requested-With: XMLHttpRequest" \
  --data ""
```

