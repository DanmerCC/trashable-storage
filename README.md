# Trashable Storage

## Descripción
Trashable Storage es una librería que proporciona una forma de gestionar el almacenamiento temporal que puede ser fácilmente descartado cuando ya no se necesita. Los archivos eliminados se mueven a una carpeta de "trash" en lugar de ser eliminados permanentemente.

## Instalación
Para instalar la librería, usa Composer:
```bash
composer require danmercc/trashable-storage
```
Configuración
Publica el archivo de configuración:
```bash
php artisan vendor:publish --provider="DanmerCC\TrashableStorage\TrashStorageServiceProvider"
```
El archivo de configuración trash-storage.php se verá así:


```bash
<?php
return [
    'trash_folder' => 'trash',
    'trashable_disks' => [
        'local',
    ],
];
```

Uso
Extender Discos
Para extender los discos configurados como "trashable", asegúrate de que están listados en trashable_disks en el archivo de configuración.

Uso en el Código
Puedes usar la funcionalidad de Trashable Storage en tu código de la siguiente manera:
```bash
<?php
use Illuminate\Support\Facades\Storage;

// Obtener el disco extendido
$disk = Storage::disk('local');

// Eliminar un archivo (se moverá a la carpeta de trash)
$disk->delete('path/to/file.txt');
```
