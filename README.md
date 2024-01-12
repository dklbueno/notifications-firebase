# Notification Firebase (App de Envio)

Essa aplicação é responsável pelo envio da notificação para o firebase que deverá ser **escutada** por outra aplicação frontend **notifications-front**

## Instalação

1. Faça uma cópia do arquivo **.env.example** como **.env**
```shell
cp .env.example .env
```

2. Crie um arquivo chamado **database.sqlite** na pasta **database**
```shell
sudo touch database/database.sqlite
```

3. Rode o comando de build do docker compose
```shell
docker compose build --no-cache
```

4. Rode o **composer install** dentro do container do docker
```shell
docker compose exec notification-firebase-php-fpm composer install
```

5. Faça a migração das tabelas dentro do container do docker
```shell
docker compose exec notification-firebase-php-fpm php artisan migrate
```

6. Rode os comandos **npm**
```shell
npm install && npm run dev
```

## Configurações Firebase

1. Crie uma conta no **console.firebase**

2. Cole as confirurações no arquivo **firebase-messaging-sw.js** na pasta public
```js
firebase.initializeApp({
    apiKey: "api-key",
    authDomain: "auth-domian",
    databaseURL: 'db-url',
    projectId: "project-id",
    storageBucket: "storage-bucket",
    messagingSenderId: "message-sender-id",
    appId: "app-id",
    measurementId: "measurement-id"
});
```

3. Cole o **SERVER KEY** na variável do **.env**
```
FIREBASE_SERVER_KEY=
```

Obs.: Para essa aplicação funcionar corretamente é necessário que exista um mesmo usuário no app de frontend