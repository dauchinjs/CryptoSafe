# CryptoSafe

## Table of contents
* [General info](#general-info)
* [Demonstration](#demonstration)
* [Technologies](#technologies)
* [Setup](#setup)

## General info
In this project it is possible to register a user account that makes a default bank account with EUR currency. Make different accounts with different currencies. Transfer money between accounts with currency conversion if needed. With the accounts you can buy and sell cryptocurrencies or short-sell them. Also bought cryptocurrencies can be transfered to a different account. You can follow all your money and cryptocurrency transactions in the history.

This project uses API keys from [CoinMarketCap](https://coinmarketcap.com/) for cryptocurrencies, [Exchange Rates API](https://exchangeratesapi.io/) for balance conversions

## Demonstration

### Home page
![home page](https://github.com/dauchinjs/CryptoSafe/tree/main/crypto-bank-demonst)

## Technologies

Project is created with:

* PHP version: 7.4
* Laravel version: 8.83.27
* MySQL version: 8.0.31-0ubuntu0.20.04.2 for Linux on x86_64 ((Ubuntu))
* Composer version: 2.4.4

## Setup

1. Clone this repository `git clone https://github.com/dauchinjs/CryptoSafe.git`
2. Install all dependencies: `composer install` and `npm install`
3. Create a database and rename the `.env.example` file to `.env` and add your credentials
4. To get the API keys: [CoinMarketCap](https://coinmarketcap.com/) and [Exchange Rates API](https://exchangeratesapi.io/)
5. To get the databases, use command `php artisan migrate` in the terminal
6. To run the project use `php artisan serve` in terminal.
