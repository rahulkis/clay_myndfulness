<?php
namespace App\Services\Interfaces;

interface InAppPuchasesEvents{
    public function planRenewed();
    public function planPurchased();
    public function planUpgraded();
    public function planDowngraded();
    public function planDisabled();
    public function planEnabled();
}
