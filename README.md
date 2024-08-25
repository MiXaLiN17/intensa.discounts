# Скидка из свойства заказа\корзины через правило работы с корзиной (1С-Битрикс)

Модуль добавляет новое действие в правила работы с корзиной:

- Применить скидку из свойства заказа
- Применить скидку из свойства элемента корзины

![image.png](https://camo.githubusercontent.com/2b51e20cf7489216fd9cc406bc99b6a81fa28ad6ca86658bc99f50de20573972/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324633643437376335332d323636642d343464302d383830652d613338333066303936363633253246696d6167652e706e673f7461626c653d626c6f636b2669643d62613365396165332d326133662d343230662d393337362d37356666323231663538636426737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

## Установка модуля

Установку модуля следует выполнять через маркетплейс [https://marketplace.1c-bitrix.ru/solutions/intensa.discounts/](https://marketplace.1c-bitrix.ru/solutions/intensa.discounts/).

## Пример

### Установка скидки из свойства заказа

Создайте свойство заказа с типом данных «Число». Установите флаг «Служебное», если свойство заполняете сами на событии заказа. В противном случае, оно будет отображаться в форме оформления заказа, и пользователь сможет самостоятельно указать скидку.

![1.png](https://camo.githubusercontent.com/5e65253dcd3e2f85f8e58f8c3aac2dfc1db82b399f8d21d2ae4de77cab4b1380/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324664626664353964382d333935392d343366392d623537332d313663383235303338646364253246312e706e673f7461626c653d626c6f636b2669643d66313633353661382d613037332d346663662d613330312d61366335313063626236383626737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

Добавьте правило работы с корзиной, заполнив стандартные настройки (название, приоритеты и прочее).

![2.png](https://camo.githubusercontent.com/c5fb53f9b9336a2c0b1159a8114c041bfe24b19180d0b6307deb47ebabd18acc/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324664356131306564642d636635632d343637652d613662352d396461303132643137666536253246322e706e673f7461626c653d626c6f636b2669643d38376563343234322d363832302d343738642d396633662d36356538306162373963646126737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

Добавьте действие «Intensa: Применить скидку из свойства заказа».

![image.png](https://camo.githubusercontent.com/32d42a77026ca3ada0c544153618eb09dc0770aa2ae860ae66706aa1c4052952/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324639633737393134352d343265632d343564382d616531312d363363323136336365356538253246696d6167652e706e673f7461626c653d626c6f636b2669643d38396436646539612d313335612d346365302d386432352d34653666363836613034373826737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

Укажите тип расчета скидки из списка:

- % — в свойство записывается процент скидки на корзину заказа (указав «не более» можно ограничить максимальную скидку в количественном выражении),
- RUB на общую сумму товаров — в свойство записывается фиксированная скидка на корзину заказа,
- RUB на каждый товар — в свойство записывается фиксированная скидка за каждый товар в корзине.

![4.png](https://camo.githubusercontent.com/cfddc4bfd06dfd267b7f302278437182fc9f59c46182a8f6cd8d142b96243c69/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324662393737663831322d356166652d343836322d613130342d646637646163373362353936253246342e706e673f7461626c653d626c6f636b2669643d30376536393837612d383231302d343264382d393139652d36353835653564636664633426737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

После создания правила, реализуйте заполнение свойства в форме оформления заказа или на событие компонента sale.order.ajax.

В случае, когда свойство заполняется непосредственно пользователем в форме оформления заказа, для применения скидки необходимо вызвать пересчет заказа *BX.Sale.OrderAjaxComponent.sendRequest()*. Не забывайте валидировать вводимые значения.

В случае, когда свойство заполняется на событии заказа (рекомендованное *OnSaleComponentOrderCreated*), не забывайте передавать $arUserResult['CALCULATE_PAYMENT'] = 'Y'.

***Пример для события в init.php***

Добавляем событие и задаем значение 399, чтобы проверить скидку.

```php
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleComponentOrderCreated',
    (static function(\Bitrix\Sale\Order $order, &$arUserResult, \Bitrix\Main\HttpRequest $request, &$arParams, &$arResult) {
        $propertyCollection = $order->getPropertyCollection();

        $property = $propertyCollection->getItemByOrderPropertyCode('BONUSES');

        if (! $property instanceof \Bitrix\Sale\PropertyValueBase) {
            return;
        }

        $property->setValue(399);
        $arUserResult['CALCULATE_PAYMENT'] = 'Y';
    })
);
```

---

Добавляем товар в корзину и оформляем заказ.

![image.png](https://camo.githubusercontent.com/d63c7b1c6285510df56c826e2d238136203a91125f25eca93753427d93ba4070/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324630323362393035372d336636312d343132622d626435662d386238393833343234363664253246696d6167652e706e673f7461626c653d626c6f636b2669643d39303038396163342d613163312d346431352d383234352d37313031643866653966656326737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

Смотрим заказ в административной части.

![image.png](https://camo.githubusercontent.com/da4944b9645cb9cc5bb4cd3b0f4b77632e67cac6e959bdd0d48ffb9f3084def6/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324633666162316534652d376239622d343062372d393962312d396236613765643765363466253246696d6167652e706e673f7461626c653d626c6f636b2669643d66316130383538652d653531662d346161342d616264312d65343162323264346635643426737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

Используя данное правило, скидка на каждую товарную позицию распределяется внутренней системой Битрикс.

### Установка скидки из свойства элемента корзины

При создании скидки необходимо выбрать действие «Intensa: Применить скидку из свойства элемента корзины».

Задать тип применения скидки:

- скидка - применяет скидку из заданного свойства. Можно указать в процентах или значение в валюте.
- наценка - позволяет задать наценку к текущей стоимости
- фиксированная цена - устанавливает значение цены из указанного свойства.

Также указать код свойства элемента корзины, из значения которого будет применяться скидка.

![image.png](https://camo.githubusercontent.com/437f6f19fb11e8141b4bc8649e72feffbcee04e044b2987d50a6a2b49d2e3b80/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324664383436303963392d346538652d343035342d626362372d366565633166663036346366253246696d6167652e706e673f7461626c653d626c6f636b2669643d30373361656466352d333135332d343039372d393638662d66653836383333336131663126737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

Заполнять данное свойство можно или же на событии (OnSaleBasketBeforeSaved|OnSaleBasketItemEntitySaved и другие), или используя стандартный механизм добавления товара.

![image.png](https://camo.githubusercontent.com/9cbf3a3352f533166e32780ed37d108b33b88a879814dcbc19bb07c2caa9d995/68747470733a2f2f7777772e6e6f74696f6e2e736f2f696d6167652f687474707325334125324625324670726f642d66696c65732d7365637572652e73332e75732d776573742d322e616d617a6f6e6177732e636f6d25324664373631346632352d303666612d343061362d393365372d33323263633337393833653925324636323561313864632d633363302d346438332d383337312d626136393231633437323630253246696d6167652e706e673f7461626c653d626c6f636b2669643d38393466616430362d346330312d346233332d396336372d31356138303965313266663226737061636549643d64373631346632352d303666612d343061362d393365372d3332326363333739383365392677696474683d32303030267573657249643d32623261376336342d666663332d343532332d386662352d6634336235353830656263632663616368653d7632)

Используя данное правило, вы сами распределяете скидку на каждый товар в корзине. Тем самым можно программировать различные маркетинговые акции, по типу 3=2 или прочие.