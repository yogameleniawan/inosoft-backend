# PT.INOSOFT TRANS SISTEM

## Daftar Isi
- [PT.INOSOFT TRANS SISTEM](#ptinosoft-trans-sistem)
  - [Daftar Isi](#daftar-isi)
  - [Setup pertama kali](#setup-pertama-kali)
  - [Git hooks](#git-hooks)
  - [Requirements](#requirements)
  - [Developments](#developments)
  - [Copyright](#copyright)

## Setup pertama kali
1. Clone repository
	```bash
	# Clone dengan SSH
	git clone git@github.com:yogameleniawan/inosoft-backend.git
	# Clone dengan HTTPS
	git clone https://github.com/yogameleniawan/inosoft-backend.git
	```
2. Install laravel dan php dependency
	```
	composer install
	```
3. Setup konfigurasi  
Buat file `.env` di root project dan copy isi file `.env.example` ke `.env`  
Ubah konfigurasi sesuai keperluan. Pastikan `APP_URL_BASE` sudah benar
	```bash
	# Unix/Linux/Windows Powershell
	cp .env.example .env
	# Windows CMD
	copy .env.example .env
	```
4. Generate application key
	```
	php artisan key:generate
	```
5. Migrasi database  
Pastikan konfigurasi database di `.env` sudah benar
	```
	php artisan migrate
	```
6. Install node dependency
	```
	npm install
	```
8. Jalankan Projek Laravel
	```
	php artisan serve
	```

## Git hooks
Automasi untuk menjalankan `composer update` atau `npm install` ketika `composer.json` atau `package.json` berubah. Pindah file `git-hooks/post-merge` ke `.git/hooks`. Pastikan file `post-merge` sudah executable.

## Requirements
- PHP >= 8.0
- MySQL >= 8.0
- [NodeJs >= 14.0](https://nodejs.org/en/download/)
- Apache >= 2.4.26 / Nginx >= 1.18
- [Laravel Requirements](https://laravel.com/docs/8.x/installation)

## Developments
1.  Run Test   
	```
    # Run Test with PHP unit
	./vendor/bin/phpunit
	```
2. [Routes Viewer](http://127.0.0.1:8000/routes)   
Lihat list routes `/routes` langsung dari browser. List route akan tampil apabila  `APP_DEBUG` env bernilai true.

3. [Documentation API Endpoint](https://documenter.getpostman.com/view/13464851/2s8YsnXFw5)

## Copyright
2022 [Yoga Meleniawan Pamungkas](https://www.github.com/yogameleniawan/)   
