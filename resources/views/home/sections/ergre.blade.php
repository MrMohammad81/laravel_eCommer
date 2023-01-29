<!-- Single Tab Content Start -->
<div class="tab-pane fade" id="orders" role="tabpanel">
    <div class="myaccount-content">
        <h3>سفارشات</h3>
        <div class="myaccount-table table-responsive text-center">
            <table class="table table-bordered">
                <thead class="thead-light">
                <tr>
                    <th> سفارش </th>
                    <th> تاریخ </th>
                    <th> وضعیت </th>
                    <th> جمع کل </th>
                    <th> عملیات </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td> 22 تیر 1399 </td>
                    <td>Pending</td>
                    <td>
                        30000
                        تومان
                    </td>
                    <td><a href="#" data-toggle="modal"
                           data-target="#ordersDetiles"
                           class="check-btn sqr-btn "> نمایش جزئیات </a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td> 22 تیر 1399 </td>
                    <td>Approved</td>
                    <td>
                        50000
                        تومان
                    </td>
                    <td><a href="#" data-toggle="modal"
                           data-target="#ordersDetiles"
                           class="check-btn sqr-btn "> نمایش جزئیات </a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td> 22 تیر 1399 </td>
                    <td>On Hold</td>
                    <td>
                        20000
                        تومان
                    </td>
                    <td><a href="#" data-toggle="modal"
                           data-target="#ordersDetiles"
                           class="check-btn sqr-btn "> نمایش جزئیات </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Single Tab Content End -->

<!-- Single Tab Content Start -->
<div class="tab-pane fade" id="address" role="tabpanel">
    <div class="myaccount-content address-content">
        <h3> آدرس ها </h3>

        <div>
            <address>
                <p>
                    <strong> علی شیخ </strong>
                    <span class="mr-2"> عنوان آدرس : <span> منزل </span> </span>
                </p>
                <p>
                    خ شهید فلان ، کوچه ۸ فلان ،فرعی فلان ، پلاک فلان
                    <br>
                    <span> استان : تهران </span>
                    <span> شهر : تهران </span>
                </p>
                <p>
                    کدپستی :
                    89561257
                </p>
                <p>
                    شماره موبایل :
                    89561257
                </p>

            </address>
            <a href="#" class="check-btn sqr-btn collapse-address-update">
                <i class="sli sli-pencil"></i>
                ویرایش آدرس
            </a>

            <div class="collapse-address-update-content">

                <form action="#">

                    <div class="row">

                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                عنوان
                            </label>
                            <input type="text" required="" name="title">
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                شماره تماس
                            </label>
                            <input type="text">
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                استان
                            </label>
                            <select class="email s-email s-wid">
                                <option>Bangladesh</option>
                                <option>Albania</option>
                                <option>Åland Islands</option>
                                <option>Afghanistan</option>
                                <option>Belgium</option>
                            </select>
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                شهر
                            </label>
                            <select class="email s-email s-wid">
                                <option>Bangladesh</option>
                                <option>Albania</option>
                                <option>Åland Islands</option>
                                <option>Afghanistan</option>
                                <option>Belgium</option>
                            </select>
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                آدرس
                            </label>
                            <input type="text">
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                کد پستی
                            </label>
                            <input type="text">
                        </div>

                        <div class=" col-lg-12 col-md-12">
                            <button class="cart-btn-2" type="submit"> ویرایش
                                آدرس
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

        <hr>

        <div>
            <address>
                <p>
                    <strong> علی شیخ </strong>
                    <span class="mr-2"> عنوان آدرس : <span> محل کار </span>
                                                            </span>
                </p>
                <p>
                    خ شهید فلان ، کوچه ۸ فلان ،فرعی فلان ، پلاک فلان
                    <br>
                    <span> استان : تهران </span>
                    <span> شهر : تهران </span>
                </p>
                <p>
                    کدپستی :
                    89561257
                </p>
                <p>
                    شماره موبایل :
                    89561257
                </p>

            </address>
            <a href="#" class="check-btn sqr-btn ">
                <i class="sli sli-pencil"></i>
                ویرایش آدرس
            </a>
        </div>

        <hr>

        <button class="collapse-address-create mt-3" type="submit"> ایجاد آدرس
            جدید </button>
        <div class="collapse-address-create-content">

            <form action="#">

                <div class="row">

                    <div class="tax-select col-lg-6 col-md-6">
                        <label>
                            عنوان
                        </label>
                        <input type="text" required="" name="title">
                    </div>
                    <div class="tax-select col-lg-6 col-md-6">
                        <label>
                            شماره تماس
                        </label>
                        <input type="text">
                    </div>
                    <div class="tax-select col-lg-6 col-md-6">
                        <label>
                            استان
                        </label>
                        <select class="email s-email s-wid">
                            <option>Bangladesh</option>
                            <option>Albania</option>
                            <option>Åland Islands</option>
                            <option>Afghanistan</option>
                            <option>Belgium</option>
                        </select>
                    </div>
                    <div class="tax-select col-lg-6 col-md-6">
                        <label>
                            شهر
                        </label>
                        <select class="email s-email s-wid">
                            <option>Bangladesh</option>
                            <option>Albania</option>
                            <option>Åland Islands</option>
                            <option>Afghanistan</option>
                            <option>Belgium</option>
                        </select>
                    </div>
                    <div class="tax-select col-lg-6 col-md-6">
                        <label>
                            آدرس
                        </label>
                        <input type="text">
                    </div>
                    <div class="tax-select col-lg-6 col-md-6">
                        <label>
                            کد پستی
                        </label>
                        <input type="text">
                    </div>

                    <div class=" col-lg-12 col-md-12">

                        <button class="cart-btn-2" type="submit"> ثبت آدرس
                        </button>
                    </div>



                </div>

            </form>

        </div>

    </div>
</div>
<!-- Single Tab Content End -->

<!-- Single Tab Content Start -->
<div class="tab-pane fade" id="wishlist" role="tabpanel">
    <div class="myaccount-content">
        <h3> لیست علاقه مندی ها </h3>
        <form class="mt-3" action="#">
            <div class="table-content table-responsive cart-table-content">
                <table>
                    <thead>
                    <tr>
                        <th> تصویر محصول </th>
                        <th> نام محصول </th>
                        <th> حذف </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="product-thumbnail">
                            <a href="#"><img
                                    src="assets/img/cart/cart-3.svg"
                                    alt=""></a>
                        </td>
                        <td class="product-name"><a href="#"> لورم ایپسوم
                            </a>
                        </td>
                        <td class="product-name">
                            <a href="#"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="product-thumbnail">
                            <a href="#"><img
                                    src="assets/img/cart/cart-4.svg"
                                    alt=""></a>
                        </td>
                        <td class="product-name"><a href="#"> لورم ایپسوم
                                متن
                            </a>
                        </td>
                        <td class="product-name">
                            <a href="#"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="product-thumbnail">
                            <a href="#"><img
                                    src="assets/img/cart/cart-5.svg"
                                    alt=""></a>
                        </td>
                        <td class="product-name"><a href="#"> لورم ایپسوم
                            </a>
                        </td>
                        <td class="product-name">
                            <a href="#"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<!-- Single Tab Content End -->

<!-- Single Tab Content Start -->
<div class="tab-pane fade" id="comments" role="tabpanel">
</div> <!-- Single Tab Content End -->
