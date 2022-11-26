ENDPOINTES (see more in routes/api.php) :

POST .../api/register - register new user

POST .../api/login - user

GET .../api/product/ - get all active products 

GET .../api/product/all - get all products

GET .../api/product/{id} - get product by id

POST .../api/product/ - create product

POST .../api/product/{id} - update product by id

GET .../api/product/store/{id} - get offers products of store

GET .../api/product/{id}/offers - get offers by product id

GET .../api/product/category/{id} - get active products by category

GET .../api/store - get all stores

GET .../api/store/{id} -get store by id

GET .../api/store/{id}/address - get addresses of store by id

GET .../api/category/ - get all categories

GET .../api/category/{id} get category by id


CONTROLLERS (see more in app/Http/Controllers):

RegisterController  -- for user register/login

ProductController - DO : ProductService, ApiResponse\Response -- for products

StoreController - DO : StoreService, ApiResponse\Response -- for stores

CategoryController - DO : CAtegoryService, ApiResponse\Response -- for categories


FRONT PART IN "front.zip"!!!


