

## log server구조

## 로그 파일 이전 load 위치 저장 파일
```bash
> mv /game/uruk/logd/table_index.json /game/log/scribe/table_index.json
```

## cron
```bash
> crontab -e
*/5 * * * * /usr/bin/php -e /game/uruk/logd/insertlog.php
55 23 * * * /usr/bin/php -e /game/uruk/logd/createtable.php
55 23 * * * /usr/bin/php -e /game/uruk/logd/droptable.php
```

