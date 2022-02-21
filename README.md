# Slim Framework 4 Skeleton Application

[![Coverage Status](https://coveralls.io/repos/github/slimphp/Slim-Skeleton/badge.svg?branch=master)](https://coveralls.io/github/slimphp/Slim-Skeleton?branch=master)

Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application. This application uses the latest Slim 4 with Slim PSR-7 implementation and PHP-DI container implementation. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application. You will require PHP 7.4 or newer.

```bash
composer create-project slim/slim-skeleton [my-app-name]
```

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run these commands 

```bash
cd [my-app-name]
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd [my-app-name]
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.


# game-uruk

### DB Table 설계

case naming convention - table, column 모두 snake case

## 기획 데이터

기획 데이터 표현 방법 - csv

기획 데이터 저장 방법 - Database Table, Key-Value Memory Cache


## 파일 설명

테이블 구성 - 전체적인 데이터 테이블 컬럼(설명 포함)

기획 데이터 - 임의 데이터

game.pdf, product.pdf - ERD

## 일정 진행

22.01.24 - 22.01.26 - 기획 데이터 (기획 데이터 테이블 구성.xlsx, 기획 데이터.xlsx 생성)

22.01.27 - 게임 데이터 (게임 데이터 테이블 구성.xlsx)

22.02.07 - ERD

## 기획 데이터 업로드 페이지

![image](https://user-images.githubusercontent.com/97434362/154876508-390d0802-7df5-4756-aa2b-236c128cd561.png)

csv 파일을 등록하면 table에 등록

