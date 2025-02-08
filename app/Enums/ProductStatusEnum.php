<?php
  
namespace App\Enums;
 
enum ProductStatusEnum:string {
    case Autorized = 'Autorizado';
    case Delivered = 'Entregado';
    case Pending = 'Pendiente';
    case Rejected = 'Rechazado';
    case NonDelivered = 'No entregado';
}