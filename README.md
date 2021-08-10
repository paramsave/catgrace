## Catgrace

##### ERD
1. user와 user의 특성(종류/외형)에 대한 관계
2. user와 질문/답변의 관계

https://drive.google.com/file/d/1wXkkCVew8OVQTj5ci2KyuCwGQdMnXE6c/view?usp=sharing

##### 아키텍쳐 설계
1. passport를 사용. 토큰을 발급하는 것만 사용.
2. 서비스단만 만들어서 데이터베이스 데이터를 가져옴.
3. 종류/외형에 대한 서비스단은 모델만 다르므로 extends 사용.

##### 환경 셋팅
- PHP 7.3, mariadb 10.6, artisan serve로 실행
- 포스트맨 사용

##### 추가 기능
- 해당 사용자의 질문/답변 모아서 보는 기능.
