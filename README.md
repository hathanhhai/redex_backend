Setup local

Just run cmd below:
docker compose -f docker-compose.yml -p redex_backend up --build -d --force-recreate 

it will run port: loclhost:2045
I selected Laravel because for quickly and this feature no need hightraffic, it Laravel also no need config or create file route it all ready there.

---
Deployment
 - Currently, it using jenkins when you push everything on branch main it will be auto trigger in jenkins
    + Create pipeline on jenkins
    + pull SCM from GIT
    + Build docker

With URL: https://redex-be.congcucuatoi.com


