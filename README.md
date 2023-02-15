# Database and Web Applications Laboratory - LBAW 2022/2023 - FEUP

## About Fashion

### Documentation

* [Documentation Presentation](welcome.md)

#### Docker Commands

Comandos Docker para iniciar a imagem disponível no Container Registry do Git do grupo, que utiliza a base de dados de produção:

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
> Primeiro é necessário efetuar *login* em <strong>/admin-panel/login</strong> e depois é feito o redirecionamento para <strong>/admin-panel</strong>.
>
>| Type | E-mail | Password |
>| ---- | ------ | -------- |
>| Collaborator | kgrishanov2@twitter.com | teste12345 |
>| Technician | up202006562@up.pt | teste12345 |

#### User Credentials

>| Type | E-mail | Password |
>| ---- | ------ | -------- |
>| example account | mmonkman0@sfgate.com | teste12345 |
