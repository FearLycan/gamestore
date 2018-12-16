<?php

use yii\db\Migration;

/**
 * Class m181216_171815_add_translations
 */
class m181216_171815_add_translations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%language}}', ['id', 'name', 'short_name', 'language_tag', 'slug', 'status'], [
            [1, 'Polski', 'pl', 'PL-pl', 'polski', 1],
            [2, 'English', 'en', 'en-US', 'english', 1]
        ]);

        $this->batchInsert('{{%translation}}', ['phrase', 'translation', 'scope', 'language_id', 'created_at'], [
            ['Game', 'Gra', 'all', 1, '2018-12-14 17:25:47'],
            ['Region', 'Region', 'all', 1, '2018-12-14 17:26:10'],
            ['Platform', 'Platforma', 'all', 1, '2018-12-14 17:26:28'],
            ['Type', 'Typ', 'all', 1, '2018-12-14 17:26:43'],
            ['Product description', 'Opis produktu', 'all', 1, '2018-12-14 17:27:14'],
            ['System requirements', 'Wymagania sprzętowe', 'all', 1, '2018-12-14 17:27:46'],
            ['Videos', 'Filmy', 'all', 1, '2018-12-14 17:28:11'],
            ['Minimal requirements', 'Minimalne wymagania', 'all', 1, '2018-12-14 17:28:39'],
            ['Recommended requirements', 'Zalecane wymagania', 'all', 1, '2018-12-14 17:29:01'],
            ['ADD TO CART', 'DODAJ DO KOSZYKA', 'all', 1, '2018-12-14 17:29:31'],
            ['Search', 'Szukaj', 'all', 1, '2018-12-14 17:29:57'],
            ['Price', 'Cena', 'all', 1, '2018-12-14 17:30:18'],
            ['Code', 'Kod', 'all', 1, '2018-12-14 17:30:31'],
            ['QTY', 'Ilość', 'all', 1, '2018-12-14 17:30:44'],
            ['A new game has been added to your Shopping Cart.', 'Nowa gra została dodana do Twojego koszyka.', 'all', 1, '2018-12-14 17:31:14'],
            ['is in your cart.', 'jest w twoim koszyku.', 'all', 1, '2018-12-14 17:31:33'],
            ['YOU MIGHT ALSO LIKE', 'POLECANE GRY', 'all', 1, '2018-12-14 17:32:31'],
            ['Buy more', 'Kontynuuj zakupy', 'all', 1, '2018-12-14 17:33:53'],
            ['Go to cart', 'Przejdź do koszyka', 'all', 1, '2018-12-14 17:35:12'],
            ['Check this game', 'Sprawdź tę grę', 'all', 1, '2018-12-14 17:36:13'],
            ['Platforms', 'Platformy', 'all', 1, '2018-12-14 17:36:44'],
            ['Regions', 'Regiony', 'all', 1, '2018-12-14 17:37:00'],
            ['Games', 'Gry', 'all', 1, '2018-12-14 17:37:20'],
            ['products', 'produktów', 'all', 1, '2018-12-14 17:37:40'],
            ['product', 'produkt', 'all', 1, '2018-12-14 17:37:49'],
            ['Min price', 'Min', 'all', 1, '2018-12-14 17:43:17'],
            ['Max price', 'Max', 'all', 1, '2018-12-14 17:43:49'],
            ['Developer', 'Developer', 'all', 1, '2018-12-14 17:45:05'],
            ['Publisher', 'Wydawca', 'all', 1, '2018-12-14 17:45:24'],
            ['Cart', 'Koszyk', 'all', 1, '2018-12-15 11:32:47'],
            ['Continue Shopping', 'Kontynuować zakupy', 'all', 1, '2018-12-15 14:19:41'],
            ['Checkout', 'Złóż zamówienie', 'all', 1, '2018-12-15 14:20:31'],
            ['Subtotal', 'Suma częściowa', 'all', 1, '2018-12-15 14:22:04'],
            ['Total', 'Suma całkowita', 'all', 1, '2018-12-15 14:22:25'],
            ['Quantity', 'Ilość', 'all', 1, '2018-12-15 14:27:29'],
            ['Delete', 'Usuń', 'all', 1, '2018-12-15 14:50:28'],
            ['Are you sure to delete this item?', 'Czy na pewno chcesz usunąć ten element?', 'all', 1, '2018-12-15 14:51:36'],
            ['Your cart is empty.', 'Twój koszyk jest pusty.', 'all', 1, '2018-12-15 15:05:15'],
            ['Are you sure to delete this promo code?', 'Czy na pewno chcesz usunąć ten kod promocyjny?', 'all', 1, '2018-12-15 20:13:43'],
            ['Summary', 'Podsumowanie', 'all', 1, '2018-12-15 22:22:25'],
            ['Back', 'Powrót', 'all', 1, '2018-12-15 23:35:18'],
            ['Promotion Code', 'Kod promocyjny', 'cart', 1, '2018-12-16 00:04:19'],
            ['value', 'wartość', 'cart', 1, '2018-12-16 00:06:23'],
            ['Delivery method', 'Sposób dostawy', 'all', 1, '2018-12-16 00:07:16'],
            ['address e-mail', 'adres e-mail', 'cart', 1, '2018-12-16 00:08:02'],
            ['Order confirmation', 'Potwierdzenie zamówienia', 'all', 1, '2018-12-16 01:15:32'],
            ['Your order has been registered.', 'Twoje zamówienie zostało zarejestrowane. ', 'all', 1, '2018-12-16 01:16:30'],
            ['You can check it', 'Możesz je sprawdzić', 'all', 1, '2018-12-16 01:17:21'],
            ['here', 'tutaj', 'all', 1, '2018-12-16 01:17:59'],
            ['Order', 'Zamówienie', 'all', 1, '2018-12-16 01:24:03'],
            ['Date', 'Data', 'all', 1, '2018-12-16 01:26:47'],
            ['Ordered games', 'Zamówione gry', 'all', 1, '2018-12-16 01:30:49'],
            ['Keys', 'Klucze', 'all', 1, '2018-12-16 01:45:35'],
            ['Order list', 'Lista zamówień', 'all', 1, '2018-12-16 15:09:58'],
            ['Order code', 'Nr. zamówienia', 'all', 1, '2018-12-16 15:30:38'],
            ['Created at', 'Data złożenia', 'all', 1, '2018-12-16 15:39:39'],
            ['Check', 'Sprawdź', 'all', 1, '2018-12-16 16:00:11'],
            ['Log out', 'Wyloguj się', 'all', 1, '2018-12-16 16:50:03'],
            ['Sign in', 'Zaloguj się', 'all', 1, '2018-12-16 16:50:42'],
            ['Sign up', 'Zarejestruj się', 'all', 1, '2018-12-16 16:51:11'],
            ['Password', 'Hasło', 'all', 1, '2018-12-16 16:55:13'],
            ['E-mail address', 'Adres e-mail', 'all', 1, '2018-12-16 16:55:43'],
            ['You don\'t have an account?', 'Nie masz konta?', 'all', 1, '2018-12-16 16:56:23'],
            ['Sing up here!', 'Zarejestruj się tutaj!', 'all', 1, '2018-12-16 16:57:53'],
            ['Name', 'Nazwa', 'all', 1, '2018-12-16 17:02:31'],
            ['Repeat password', 'Powtórz hasło', 'all', 1, '2018-12-16 17:04:33'],
            ['Already have an account?', 'Masz już konto?', 'all', 1, '2018-12-16 17:05:23'],
            ['Sing up here!', 'Zaloguj się tutaj!', 'all', 1, '2018-12-16 17:07:04'],
            ['The entered passwords are different', 'Podane hasła są różne', 'all', 1, '2018-12-16 17:08:49'],
            ['The account has not been activated', 'Konto nie zostało aktywowane', 'all', 1, '2018-12-16 17:09:45'],
            ['Invalid email address or password', 'Błędny adres e-mail lub hasło', 'all', 1, '2018-12-16 17:10:20'],
            ['Your cart is empty.', 'Twój koszyk jest pusty.', 'all', 1, '2018-12-16 17:13:53'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181216_171815_add_translations cannot be reverted.\n";

        return false;
    }

}
