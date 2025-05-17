<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
    

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // verifica si el telefono ingresado por el usuario tiene un cero al inicio y en caso de
        // que si, lo elimina
        if (isset($data['phone']) && $data['phone'][0] === '0') {
            $data['phone'] = substr($data['phone'], 1);
        }

        // verifica el documento ingresado y en caso de que tenga 0 al inicio lo elimina
        if (isset($data['document']) && $data['document'][0] === '0') {
            $data['document'] = substr($data['document'], 1);
        }

        // verifica el email ingresado y lo convierte a minusculas
        if (isset($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }

        // verifica el first_name, last_name, y company_name ingresados y los convierte a mayusculas
        if (isset($data['first_name'])) {
            $data['first_name'] = strtoupper($data['first_name']);
        }
        if (isset($data['last_name'])) {
            $data['last_name'] = strtoupper($data['last_name']);
        }
        if (isset($data['company_name'])) {
            $data['company_name'] = strtoupper($data['company_name']);
        }

        return $data;
    }

    // Recarga la pagina al guardar
    protected function afterCreate(): void
    {
        $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->record]));
    }

    // Personaliza el mensaje de guardado
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cliente creado correctamente';
    }
}
