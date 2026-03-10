<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry as ComponentsTextEntry;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;


class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->tabs([
                        // TAB 1: Detail dengan Icon
                        Tab::make('Product Details')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                ComponentsTextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),

                                ComponentsTextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('success'),
                                
                                ComponentsTextEntry::make('description')
                                    ->label('Product Description')
                                    ->html(),
                            ]),

                        // TAB 2: Harga & Stok dengan Badge Dinamis
                        Tab::make('Price and Stock')
                            ->icon('heroicon-m-banknotes')
                            ->schema([
                                ComponentsTextEntry::make('price')
                                    ->label('Product Price')
                                    ->money('idr') // Format Rupiah otomatis
                                    ->weight('bold'),

                                ComponentsTextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->badge()
                                    // 1 & 2. Badge Dinamis & Warna Berbeda berdasarkan jumlah
                                    ->color(fn (string $state): string => match (true) {
                                        $state <= 5 => 'danger',
                                        $state <= 20 => 'warning',
                                        default => 'success',
                                    })
                                    ->icon('heroicon-o-cube'),
                            ]),

                        // TAB 3: Media
                        Tab::make('Media & Status')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),
                                IconEntry::make('is_active')
                                    ->label('Active')
                                    ->boolean(),
                            ]),
                    ])
                    ->columnSpanFull()
                    // 3. Ubah menjadi Vertical (Hapus baris ini jika ingin Horizontal)
                    ->vertical(), 
            ]);
    }
    }
