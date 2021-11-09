<?php
namespace App\Constants;


abstract class PaymentModes
{
    const CASH = 1;
    const CHECK = 2;
    const CREDIT_MEMO = 3;
    const CHARGED = 4;
}