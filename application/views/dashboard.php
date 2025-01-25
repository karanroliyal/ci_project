<?php $title = "Dashboard";
include_once "templates/header.php" ?>

<div class="project-layout-main-wrapper">

    <div class="d-flex natigation_main_wrapper align-items-center bg-primary-my">
        <?php include_once "templates/navigation.php"; ?>
    </div>

    <div class="row sidebar_content_main_wrapper ">

        <div class="col-md-2 sidebar_wrapper">

            <?php include_once "templates/sidebar.php"; ?>


        </div>

        <div class="col-md-10 content_wrapper">

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All user</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Add user</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!-- Live search form with users table  -->
                <div class="tab-pane fade show active tab-padding" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                    <div class="w-100">

                        <!-- Live search form start -->
                        <form class="tableDataForm row align-items-center my-bg-b my-color" id="liveSearchForm">

                            <div class="col-md-1 col-sm-6 col-xl-1">
                                <label for="" class="form-label">Id</label>
                                <input type="number" name="id" class="form-control">
                            </div>

                            <div class="col-md-3 col-sm-6 col-xl-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="col-md-3 col-sm-6 col-xl-3">
                                <label for="" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="col-md-3 col-sm-6 col-xl-3">
                                <label for="" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="col-md-2 col-sm-6 col-xl-2 mt-4 d-flex justify-content-center">
                                <button type="reset" class="btn btn-danger ">reset</button>
                            </div>

                            <input type="hidden" name="table_name" value="user_master">
                            <input type="hidden" name="columnToShow" value="id,name,email,phone"> <!-- order also be same as table shown on frontend -->
                            <input type="hidden" name="currentPage" id="pageId" value="1">
                            <input type="hidden" name="pageLimit" id="limit" value="5">
                            <input type="hidden" name="sortOn" id="sortOn">
                            <input type="hidden" name="sortOrder" id="sortOrder">

                        </form>
                        <!-- Live search form end -->

                        <!-- pagination and limit of records select start  -->
                        <div class="d-flex justify-content-between align-items-end mb-3 mt-3">

                            <!-- select limit  -->
                            <div>
                                <label for="rowId" class="form-label">Select no. of rows</label>
                                <select id="rowId" class="form-select">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <!-- select limit  -->

                            <!-- pagination  -->
                            <div class="dynamicPagination">
                                <!-- dynamic pagination comes here  -->
                                js
                            </div>
                            <!-- pagination  -->

                        </div>
                        <!-- pagination and limit of records select end  -->

                        <!-- Dynamic table and pagination start  -->
                        <div class="table-container mt-4">

                            <!-- Showing Data table start  -->
                            <table class="table">

                                <thead>
                                    <th>Sno.</th>
                                    <th class="sortingClass" data-sort="id">Id <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="name">Name <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="email">Email <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="phone">Phone <i class="bi bi-arrow-down-up"></i></th>
                                    <th colspan="2" class="text-center">Action</th>
                                </thead>

                                <tbody class="myDynamicTable">
                                    <!-- here my dynamic table will come  -->
                                </tbody>

                            </table>
                            <!-- Showing Data table end  -->

                        </div>
                        <!-- Dynamic table and pagination end  -->



                    </div>

                </div>
                <!-- Adding Data into database -->
                <div class="tab-pane fade tab-padding" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    <!-- Data form Start  -->
                    <form class="row " id="tableData">

                        <div class="col-md-6 mb-3">
                            <label for="nameId" class="form-label">Name</label>
                            <input type="text" class="form-control" id="nameId" name="name" maxlength="70">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phoneId" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phoneId" name="phone" maxlength="10">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailId" class="form-label">Email</label>
                            <input type="text" class="form-control" id="emailId" name="email" maxlength="100">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="passwordId" class="form-label">Password</label>
                            <input type="password" class="form-control" id="passwordId" name="password" maxlength="15">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="imageId" class="form-label">Profile</label>
                            <input type="file" class="form-control" id="imageId" name="image" accept=".jpg, .jpeg, .png, .gif">
                            <small class="text-danger error"></small>
                        </div>

                        <input type="hidden" id="userId" name="id">
                        <input type="hidden" name="table" value="user_master">
                        <input type="hidden" name="upload-path-of-image" value="./profiles">

                        <div class="col-md-2 mt-4">
                            <button type="button" class="add-user btn btn-dark" onclick="sendData()">Add user</button>
                            <button type="button" class="update-user d-none btn btn-dark">Update user</button>
                        </div>

                        <!-- Backend Alerts  -->
                        <div class="alert alert-success my-backend-success d-none" style="position: absolute;width: 35%;right: 10px; top:10px" role="alert">
                        </div>
                        <div class="alert alert-danger my-backend-error d-none" style="position: absolute;width: 35%;right: 10px; top:10px" role="alert">
                        </div>
                        <!-- Backend Alerts  -->

                    </form>
                    <!-- Data form End  -->

                </div>
            </div>




        </div>

    </div>

</div>



<?php include_once "templates/footer.php" ?>