<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry as ComponentsTextEntry;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;


class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                ComponentsSection::make('Product Info')
                    ->schema([
                        ComponentsTextEntry::make('name')
                            ->label('Product Name')
                            ->weight('bold')
                            ->color('primary'),
                        ComponentsTextEntry::make('id')
                            ->label('Product ID'),
                        // 1. Badge SKU dengan warna berbeda (warning/kuning)
                        ComponentsTextEntry::make('sku')
                            ->label('Product SKU')
                            ->badge()
                            ->color('warning'),
                        ComponentsTextEntry::make('description')
                            ->label('Product Description')
                            ->html(), // Mendukung format Markdown/HTML [cite: 76, 216]
                        ComponentsTextEntry::make('created_at')
                            ->label('Product Creation Date')
                            ->date('d M Y')
                            ->color('info'),
                    ])
                    ->columnSpanFull(),
                ComponentsSection::make('Pricing & Stock')
                    ->schema([
                        // 3. Format harga menjadi Rp dengan formatStateUsing()
                        ComponentsTextEntry::make('price')
                            ->label('Product Price')
                            ->icon('heroicon-o-currency-dollar')
                            ->formatStateUsing(fn(string $state): string => "Rp " . number_format($state, 0, ',', '.')),
                        // 2. Tambahkan icon pada Stock
                        ComponentsTextEntry::make('stock')
                            ->label('Product Stock')
                            ->icon('heroicon-o-cube'),
                    ])->columnSpanFull(),
                ComponentsSection::make('Image and Status')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Product Image')
                            ->disk('public'),
                        IconEntry::make('is_active')
                            ->label('Is Active')
                            ->boolean(),
                        IconEntry::make('is_featured')
                            ->label('Is Featured')
                            ->boolean()
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
