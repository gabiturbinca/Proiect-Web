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
        <h1>Admin page:</h1>
        <h2>See your users' activity, their orders and the gifts in the app.</h2>
    </div>

    <div id ="admin__container_mini">
        <div class="admin__buttons">
             <button class ="btn btn--primary" type="button" id="users">Users</button>
             <button class ="btn btn--primary" type="button" id="gifts">Gifts</button>
             <button class ="btn btn--primary" type="button" id="orders">Orders</button>
             <button class ="btn btn--primary" type="button" id="addGift">Add a new gift</button>
             <button class ="btn btn--primary" type="button" id="resetPassword">Passwords requests</button>
             <button class ="btn btn--accent admin__buttons__report" type="button" id="report">Generate report</button>
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
                        <th>Change password</th>
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
                <td class="cell_change_password"><button type="button" class="btn btn--accent change-password" data-userId="">Change their password</button></td>
            </tr>
        </template>
        
        
        <template id="users__requests__container">
            <table class="admin__table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Identifier</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Accept</th>
                        <th>Deny</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </template>

        <template id="user__requests_row">
            <tr>
                <td class="cell__id"></td>
                <td class="cell__identifier"></td>
                <td class="cell__message"></td>
                <td class="cell__status"></td>
                <td class="cell_accept"><button type="button" class="btn btn--accent accept" data-requestId="">Accept</button></td>
                <td class="cell_deny"><button type="button" class="btn btn--accent deny" data-requestId="">Deny</button></td>
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
                        <th>Change properties</th>
                        <th>Add image</th>
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
                <td class="cell__change"><button type="button" class="btn btn--accent gift__change-btn" data-giftId="">Modify</button></td>
                <td class="cell__image">
                    <label class="btn btn--accent gift__image-label"> Add image
                        <input type="file" accept="image/*" class="gift__image-input" hidden>
                    </label>
                </td>
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

        <template id="report_form__container">
            <form id="report_form">
                <div class="field">
                    <label for="report_type">Report type</label>
                    <select id="report_type" name="type" class="report__type-select">
                        <option value="orders">Orders</option>
                        <option value="users">Users</option>
                        <option value="categories">Categories</option>
                    </select>
                </div>

                <div class="field">
                    <label for="report_from">From</label>
                    <input type="date" id="report_from" name="from">
                </div>

                <div class="field">
                    <label for="report_to">To</label>
                    <input type="date" id="report_to" name="to">
                </div>

                <div class="field" id="report__category-field">
                    <label for="report_category">Category</label>
                    <select id="report_category" name="category" class="report__category-select">
                        <option value="">All categories</option>
                    </select>
                </div>

                <div class="field">
                    <label for="report_format">Format</label>
                    <select id="report_format" name="format" class="report__format-select">
                        <option value="pdf">PDF</option>
                        <option value="html">HTML</option>
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                    </select>
                </div>

                <button type="submit" class="btn btn--primary btn-generate-report">Generate</button>
            </form>
        </template>

        <template id="add_gift__container">
            <form id="add_gift_form">
                <div class="field">
                    <label for="name">Gift name</label>
                    <input type="text" id="name" name="name" placeholder="Enter a name...">
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="Enter a description...">
                </div>

                
                <div class="field">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" placeholder="Enter a price..." step="any">
                </div>
                
                <fieldset>
                    <legend class="form__legend">Choose the category of the gift</legend>
                    <div class="field">
                        <div class="form__options" id="form__options__category">
                            <template id="category_template">
                                <select class="gift__category-select">
                                    
                                </select>
                            </template>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset>
                    <legend class="form__legend">Choose the brand of the gift</legend>
                    <div class="field">
                        <div class="form__options" id="form__options__brand">
                            <template id="brand_template">
                                <select class="gift__brand-select">
                                    
                                </select>
                            </template>
                        </div>
                    </div>
                </fieldset>
                

                <div class="field">
                    <label for="specifications">Add specifications</label>
                    <input type="textarea" id="specifications" name="specifications" placeholder="Enter any missing information about the gift...">
                </div>

                <fieldset class="form__group">
                    <legend class="form__legend">Add tags to the gift</legend>

                    <div class="form__options" id="form__options__tag">
                        <template id="tag_template">
                            <article class="form__checkbox" data-tagId="">
                                <input type="checkbox" value="" class="checkbox__input" name="" id="">
                                <label for="" class="checkbox__label"></label>
                            </article>
                        </template>
                    </div>
                </fieldset>


                <fieldset class="form__group">
                    <legend class="form__legend">Choose the circumstances the gift would be good for</legend>

                    <div class="form__options" id="form__options__circumstance">
                        <template id="circumstance_template">
                            <article class="form__checkbox" data-circumstanceId="">
                                <input type="checkbox" value="" class="checkbox__input" name="" id="">
                                <label for="" class="checkbox__label"></label>
                            </article>
                        </template>
                    </div>
                </fieldset>

                 <fieldset class="form__group">
                    <legend class="form__legend">Choose the contexts the gift would be good for</legend>

                    <div class="form__options" id="form__options__context">
                        <template id="context_template">
                            <article class="form__checkbox" data-contextId="">
                                <input type="checkbox" value="" class="checkbox__input" name="" id="">
                                <label for="" class="checkbox__label"></label>
                            </article>
                        </template>
                    </div>
                </fieldset>
                
                <button type="submit" class="btn btn--primary btn-add-gift">Add gift</button>
            </form>
        </template>

        <div id="buttons" class="invisible">
            <button type="button" class="btn btn--accent" id="btn__prev">Prev</button>
            <button type="button" class="btn btn--accent" id="btn__next">Next</button>
         </div>
    </div>

</section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>

