<?php

namespace App\Filament\Resources\Products\Schemas; // Pastikan ini sesuai folder 

use Filament\Actions\Action as ActionsAction;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Action;



class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    // Step 1: Product Info Detail
                    Step::make('Product Info')
                        ->icon('heroicon-o-information-circle')
                        ->description('Isi Informasi Produk')
                        ->schema([
                            Group::make([
                                TextInput::make('name')->required(),
                                TextInput::make('sku')->required(),
                            ])->columns(2),
                            MarkdownEditor::make('description')
                                ->columnSpanFull(),
                        ]),
                    //step2: Prosuct Prices
                    Step::make('Product Price and Stock')
                        ->icon('heroicon-o-currency-dollar')
                        ->description('Isi Harga Produk')
                        ->schema([
                            Group::make([
                                TextInput::make('price')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('stock')
                                    ->required(),
                            ])->columns(2),
                            MarkdownEditor::make('description')
                        ]),
                    //step3 : media
                    Step::make('Media & Status')
                        ->icon('heroicon-o-photo')
                        ->description('Upload gambar dan atur status')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('products'),
                            Checkbox::make('is_active'),
                            Checkbox::make('is_featured'),
                        ]),
                ])->columnSpanFull()
                    ->submitAction(
                        ActionsAction::make('save')
                            ->label('Save Product')
                            ->color('primary')
                            ->submit('save')
                    )
            ]);
    }
}
