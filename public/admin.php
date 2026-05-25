<?php
    $page_title = 'Pagina admin';
    $page_css   = 'admin';
    $page_js = 'admin';
    require __DIR__ . '/../templates/header.php';
    if (!$isAdmin) {
        header('Location: /home.php');
        exit;
    }
?>

<section class="admin__container">
    <div class="admin__title">
        <h1>Pagina de admin:</h1>
        <h2>Observă activitatea utilizatorilor, comenzile lor și cadourile din aplicație.</h2>
    </div>

    <div id ="admin__container_mini">
        <div class="admin__buttons">
             <button class ="btn btn--primary" type="button" id="users">Utilizatori</button>
             <button class ="btn btn--primary" type="button" id="gifts">Cadouri</button>
             <button class ="btn btn--primary" type="button" id="orders">Comenzi</button>
             <button class ="btn btn--primary" type="button" id="addGift">Adaugă cadou</button>
        </div>

        <div id="admin__data_container"></div>
        <template id="users__container">
            <table class="admin__table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </template>

        <template id="user__row">
            <tr>
                <td class="cell__id"></td>
                <td class="cell__username"></td>
                <td class="cell__email"></td>
                <td class="cell__role"><span class="role-badge"></span></td>
            </tr>
        </template>

        <template id="gifts__container">
            <table class="admin__table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Score</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </template>

        <template id="orders__container">
            <table class="admin__table">
                <thead>
                    <tr>
                        <th>Gift name</th>
                        <th>Recipient</th>
                        <th>Ordered by</th>
                        <th>Address</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Choose new status</th>
                        <th>Submit</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </template>

        <template id="gift__row">
            <tr>
                <td class="cell__name"></td>
                <td class="cell__description"></td>
                <td class="cell__price"></td>
                <td class="cell__score"></td>
                <td class="cell__delete"><button type="button" class="btn btn--accent gift__delete-btn" data-giftId="">Delete</button></td>
            </tr>
        </template>

        <template id="order__row">
            <tr>
                <td class="cell__gift_name"></td>
                <td class="cell__recipient"></td>
                <td class="cell_user"></td>
                <td class="cell__address"></td>
                <td class="cell__quantity"></td>
                <td class="cell__status"></td>
                <td class="cell__change_status">
                    <select class="order__status-select" data-orderId="">
                        <option value="placed">placed</option>
                        <option value="shipped">shipped</option>
                        <option value="delivered">delivered</option>
                        <option value="cancelled">cancelled</option>
                    </select>
                </td>
                <td class="change__button"><button type="button" class="btn btn--accent order__change-status-btn" data-orderId="">Change status</button></td>
            </tr>
        </template>

        <template id="add_gift__container">
            <form id="add_gift_form">
                <div class="field">
                    <label for="name"></label>
                    <input type="text" id="name" name="name" placeholder="Enter a name...">
                </div>

                <div class="field">
                    <label for="description"></label>
                    <input type="text" id="description" name="description" placeholder="Enter a description...">
                </div>
                <div class="field">
                    
                </div>
            </form>
        </template>

        <!-- name:            $data['name'],
            description:     $data['description'] ?? null,
            price:           (float) $data['price'],
            categoryId:      (int) $data['category_id'],
            brandId:         isset($data['brand_id']) ? (int) $data['brand_id'] : null,
            specifications:  $data['specifications'] ?? null,
            tagIds:          $this->normalizeIntArray($data['tags'] ?? []),
            circumstanceIds: $this->normalizeIntArray($data['circumstances'] ?? []),
            contextIds:      $this->normalizeIntArray($data['contexts'] ?? []), -->

        <div id="buttons" class="invisible">
            <button type="button" class="btn btn--accent" id="btn__prev">Prev</button>
            <button type="button" class="btn btn--accent" id="btn__next">Next</button>
         </div>
    </div>

</section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>

