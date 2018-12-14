# Composer Installer for XE

이 패키지는 composer 를 통한 XE 플러그인의 설치를 돕기위한 `composer-plugin` 입니다.

플러그인이 패키지에 의해 정상적으로 설치되기 위해서는 `composer.json` 에 작성되는 항목중에 다음 조건을 만족해야 합니다.

- `type`은 반드시 `xpressengine-plugin` 으로 지정되어야 합니다.
- 플러그인의 이름에 vendor 명은 반드시 `xpressengine-plugin` 이어야 합니다. (ex. `"xpressengine-plugin/패키지명"`)

`composer.json` 항목에 대한 자세한 내용은 [여기](https://getcomposer.org/doc/04-schema.md) 를 참고해주세요.

플러그인에 대한 정보가 더 필요한 경우 [여기](https://xpressengine.gitbook.io/xpressengine-manual/ko/d50c-b7ec-adf8-c778) 를 참고해주세요.
