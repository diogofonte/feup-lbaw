# Database and Web Applications Laboratory - LBAW 2022/2023 - FEUP

## About Fashion

### Documentation

* [Documentation Presentation](welcome.md)

#### Docker Commands

Docker commands to launch the image available in the group's Git Container Registry, which uses the production database:

```
docker run -it -p 8000:80 --name=lbaw2251 -e DB_DATABASE="lbaw2251" -e DB_SCHEMA="lbaw2251" -e DB_USERNAME="lbaw2251" -e DB_PASSWORD=xxJlDZqv git.fe.up.pt:5050/lbaw/lbaw2223/lbaw2251
```
```
docker exec -it lbaw2251 bash
```
```
root@2804d54698c0:/# tail -f /var/log/nginx/error.log    # follow the errors
root@2804d54698c0:/# tail -f /var/log/nginx/access.log   # follow the accesses
```

#### Administration Credentials

> Administration URL: <strong>/admin-panel</strong>.
> 
> First, you need to *login* in <strong>/admin-panel/login</strong> and then you are redirected to <strong>/admin-panel</strong>.
>
>| Type | E-mail | Password |
>| ---- | ------ | -------- |
>| Collaborator | kgrishanov2@twitter.com | teste12345 |
>| Technician | up202006562@up.pt | teste12345 |

#### User Credentials

>| Type | E-mail | Password |
>| ---- | ------ | -------- |
>| example account | mmonkman0@sfgate.com | teste12345 |

---

Project Final Grade: 19

Alexandre Correia - up202007042@edu.fe.up.pt <br> Ana Sofia Costa - up202007602@edu.fe.up.pt <br> Daniel Rodrigues - up202006562@edu.fe.up.pt <br> Diogo Fonte - up202004175@edu.fe.up.pt
