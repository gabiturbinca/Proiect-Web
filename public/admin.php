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


        <template id="gift__row">
            <tr>
                <td class="cell__name"></td>
                <td class="cell__description"></td>
                <td class="cell__price"></td>
                <td class="cell__score"></td>
                <td class="cell__delete"><button type="button" class="btn btn--accent gift__delete-btn">Delete</button></td>
            </tr>
        </template>

        <template id="order__container">
            <p class="card__desc"><span class="card__label">Cadou:</span> <span class="card__gift_name"></span></p>
            <p class="card__desc"><span class="card__label">Data:</span> <span class="card__time"></span></p>
            <p class="card__desc"><span class="card__label">Adresă:</span> <span class="card__address"></span></p>
            <p class="card__desc"><span class="card__label">Descriere:</span> <span class="card__description"></span></p>
            <p class="card__desc"><span class="card__label">Cantitate:</span> <span class="card__quantity"></span></p>
            <p class="card__desc"><span class="card__label">Status:</span> <span class="card__status"></span></p>
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
            <span id="page__indicator"></span>
            <button type="button" class="btn btn--accent" id="btn__next">Next</button>
         </div>
    </div>

</section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>

