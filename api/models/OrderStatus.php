<?php

enum OrderStatus: string {
    case PLACED    = 'placed';
    case SHIPPED   = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
