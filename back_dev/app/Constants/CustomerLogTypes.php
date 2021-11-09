<?php
namespace App\Constants;


abstract class CustomerLogTypes
{
    const TYPE1 = 'Additional Purchase (charged)';
    const TYPE2 = 'Payment';
    const TYPE3 = 'Deletion of Purchase';
    const TYPE4 = 'Deletion of Payment';
    const TYPE5 = 'Manual Entry';
    const TYPE6 = 'Deletion of the Manual Entry';
}