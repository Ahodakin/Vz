<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\Auth\LoginController;
use App\Http\Controllers\Backoffice\adminController;
use App\Http\Controllers\Backoffice\AccountManager\AccountManagerController;
use App\Http\Controllers\Backoffice\Prospection\ProspectingController;
use App\Http\Controllers\Backoffice\CRUD\Guarantee\GuaranteeController;
use App\Http\Controllers\Backoffice\CRUD\Category\CategoryController;
use App\Http\Controllers\Backoffice\CRUD\Reglementary\OtherController;
use App\Http\Controllers\Backoffice\CRUD\Company\CompanyController;
use App\Http\Controllers\Backoffice\UsersManager\UsersManagerController;
use App\Http\Controllers\Backoffice\Order\DetailsOrderController;
use App\Http\Controllers\Backoffice\Order\UpdateOrderInfosController;
use App\Http\Controllers\Backoffice\Client\ClientManagerController;
use App\Http\Controllers\Backoffice\Contracts\ContractsController;
use App\Http\Controllers\Backoffice\Client\EspacePersoController;
use App\Http\Controllers\Backoffice\Notifications\CallMeController;
use App\Http\Controllers\Backoffice\Repports\RepportsController;
use App\Http\Controllers\Backoffice\DeliveryTour\DeliveryTourController;
use App\Http\Controllers\Backoffice\Order\StatusOrderController;
use App\Http\Controllers\Backoffice\Revives\RevivesController;
use App\Http\Controllers\Backoffice\ImportExportData\ExportDataController;
use App\Http\Controllers\Backoffice\Search\AdvancedSearchController;

Route::controller(LoginController::class)->group(function () {

    Route::get('loginadmin', 'showLoginForm')->name('loginform')->middleware('guest');
    Route::post('/myspace/login',  'PostLogin')->name('PostLogin');
    Route::get('/myspace/locked', 'showLocked')->name('showspaceLocked');
    Route::post('/myspace/dologinfromlock', 'PostLocked')->name('PostSpaceLocked');
    Route::get('logout', 'logout')->name('logout');

});


Route::middleware(['auth'])->group(function () {

    Route::controller(adminController::class)->group(function () {

        Route::get('/me/dashboard', 'showDashboard')->name('spaceDashboard');
        Route::post('/admin/commande/sinistre', 'declarerSinistre')->name('commande.sinistre');
    });

    Route::controller(AccountManagerController::class)->group(function () {
        Route::get('/me/profil', 'showProfile')->name('profilepage');
        Route::post('/me/editprofile', 'editProfile')->name('editProfile');
        Route::post('/me/editpassword', 'editPassword')->name('editPassword');
    });

  // gerer mes prospects
    Route::controller(ProspectingController::class)->group(function () {
      
        Route::get('/admin/devis/creer', 'ShowCreateQuotationForm')->name('devis.creer');
        Route::get('/admin/devis/list', 'ShowListQuotationPage')->name('devis.list');
        Route::get('/admin/devis/list/all', 'ShowListAllQuotationPage')->name('devis.list.all');
        Route::get('/admin/prospect/send_sms', 'ShowSendSMSPage')->name('prospect.send-sms');
        Route::post('/admin/devisauto/post', 'StoreAutoQuotation')->name('devis.auto.post');
        Route::post('/admin/devismoto/post', 'traitMotoQuotation')->name('devis.moto.post');
        Route::get('/admin/devis/moto/creer', 'ShowCreateMotoQuotationForm')->name('devis.moto.creer');
        Route::get('/admin/devis/voyage/creer', 'ShowCreateVoyageQuotationForm')->name('devis.voyage.creer');


        Route::get('/admin/commandes/waitingdelivery/list', 'ShowListOrderWaitingDeliveryPage')->name('orders.waitingdelivery.list');
        Route::get('/admin/commandes/waitingdelivery/liste', 'ShowListOrderWaitingDeliveryTour')->name('orders.waitingdelivery.list.tour');
        Route::get('/admin/list/sinistre', 'showSinistre')->name('sinistre.list');

        Route::get('/admin/details-sinistre/{id_sinistre}', 'detailsSinistre')->name('sinistre.details');
        Route::post('/admin/post-details-sinistre', 'postDetailsSinistre')->name('sinistre.details.post');
        Route::post('/admin/post-details-sinistre-decision', 'postDetailsSinistreDecision')->name('sinistre.details.decision');
        Route::get('/admin/new-sinistre', 'newSinistre')->name('sinistre.new');
        Route::post('/admin/post-sinistre', 'postSinistre')->name('sinistre.post');

        Route::get('/admin/commandes/list', 'ShowListOrderPage')->name('orders.list');

        Route::get('/admin/delete/ordertodeliverytour/{id_order}', 'deleteOrderToDeliverytour')->name('deleteOrderToDeliveryTour');
    });

    //Details devis
    Route::controller(DetailsOrderController::class)->group(function () {
        Route::get('/admin/devis/details/{id}/{aid}', 'Quotedetails')->name('devis.details');
        Route::get('/admin/devis/voyage/details/{id}/{aid}', 'TravelQuotedetails')->name('devis.voyage.details');
        Route::get('/admin/devis/timeline/{id}', 'OrderTimeLine')->name('devis.timeline');
        Route::get('/admin/devis/details/{id}/{aid}', 'Quotedetails')->name('devis.details');

        Route::get('/admin/commande/a-encaisser', 'commandeAencaisser')->name('commande.a.encaisser');
        Route::get('/admin/commande/traitees', 'commandeTraiter')->name('commande.traitees');
        Route::get('/admin/devis/pdf/{comp_id}/{quote_id}', 'loadDevisPDF')->name('showDevisPDF');
        Route::get('/admin/devis/voyage/pdf/{comp_id}/{quote_id}', 'loadDevisVoyagePDF')->name('showDevisVoyagePDF');
    });


    Route::controller(DeliveryTourController::class)->group(function () {
        Route::get('/admin/livraison/tocash/list', 'ShowListOrderDeliveryToCash')->name('delivery.tocash.list');
        Route::get('/admin/tocash/tour-details/{id_tour}', 'ShowDeliveryTourDetailsToCashPage')->name('delivery.tocash.details');
        Route::get('/admin/livraison/list', 'ShowListOrderWaitingDeliveryPage')->name('delivery.list');
        Route::get('/admin/livraison/tour-details/{id_tour}', 'ShowDeliveryTourDetailsPage')->name('delivery.details');

        Route::post('/order/notdelivery', 'orderNotDelivery')->name('order.notdelivery');
        Route::post('/order/confirmdelivery','orderConfirmDelivery')->name('order.notdelivery');
        Route::get('/admin/operation/tour-details/{id_tour}', 'ShowDeliveryTourOperationDetailsPage')->name('delivery.operation.details');

        Route::post('/admin/deliverytour/post', 'createDeliveryTour')->name('deliverytour.post');
        Route::post('/admin/deliverytour/update', 'updateDeliveryTour')->name('deliverytour.update');
        Route::post('/admin/settodelivery/post', 'setOrderToDeliveryTour')->name('settodelivery.post');
        Route::get('/admin/deliverytour/signature/pdf/{id_sign}', 'DeliveryTourSignaturePdf')->name('deliverytour.signature.pdf');

        Route::get('/admin/startdeliverytour/{id_tour}', 'startDeliveryTour')->name('deliverytour.start');
        Route::get('/admin/closedeliverytour/{id_tour}', 'closeDeliveryTour')->name('deliverytour.close');
        Route::get('/admin/getdeliverytour/{id_tour}', 'getDeliveryTour')->name('deliverytour.get');
    });


    Route::controller(UpdateOrderInfosController::class)->group(function () {

        Route::post('/admin/devis/update/vehicule', 'updateVehicule')->name('devis.vehicule.update');
        Route::post('/admin/devis/update/client', 'updateClient')->name('devis.client.update');
        Route::post('/admin/devis/update/garantie', 'updateGarantie')->name('devis.garantie.update');
        Route::post('/admin/devis/update/service', 'updateService')->name('devis.service.update');
        Route::post('/admin/devis/update/reduction', 'updateReduction')->name('devis.reduction.update');
        Route::get('/admin/priority-order/{qid}', 'priorityOrder')->name('devis.priority.up');
    });

    Route::controller(StatusOrderController::class)->group(function () {

        Route::post('/admin/devis-auto/validation', 'validateOrder')->name('devis.vehicule.validate');
        Route::post('/admin/devis-auto/confirm', 'confirmDevis')->name('devis.vehicule.confirm');
        Route::get('/admin/cancel-commande/{id_quote}', 'cancelCommande')->name('order.cancel');
    });

    Route::controller(RevivesController::class)->group(function () {
	    Route::post('/admin/revive/create', 'saveReviveForOrder')->name('createRevive');
        Route::get('/admin/revive', 'showReviveConfigPage')->name('configRevive');
    });

    Route::controller(CompanyController::class)->group(function () {
        Route::get('/admin/company', 'showPage')->name('companyPage');
        Route::get('/admin/company/tarif/{id_comp}', 'showTarifPage')->name('tarifCompany');
        Route::get('/admin/deletecompany/{id_comp}', 'deleteCompany')->name('deleteCompany');
        Route::post('/admin/editcompany', 'editCompany')->name('editCompany');
    });

    Route::controller(ClientManagerController::class)->group(function () {

        Route::get('/admin/clients', 'afficherClient')->name('client.afficher');
        Route::get('/admin/client/detail/{id}', 'detailClient')->name('client.detail');
    });

    Route::controller(OtherController::class)->group(function () {
        Route::get('/admin/config/other','showConfigPage')->name( 'configOtherReglementary');
        Route::post('/admin/auto/otherrate', 'editAutoOtherRate')->name('editAutoReglementaryOther');
    });

    Route::controller(EspacePersoController::class)->group(function () {
        Route::get('/admin/espace-perso', 'showAllSpace')->name('espacePerso');
        Route::post('/admin/espace-perso/create/', 'createNewSpace')->name('createEspacePerso');
        Route::post('/admin/reset-password/espace-perso', 'resetPassword')->name('espace-perso.resetPassword');
        Route::get('/admin/espace-perso/delete/{phone_number}', 'deleteSpace')->name('deleteEspacePerso'); 
       
    });


    //Config Garanties AUTO
    Route::controller(GuaranteeController::class)->group(function () {
        Route::get('/admin/guarantee', 'showPage')->name('guaranteePage');
        Route::get('/admin/guarantee/{id}',  'getGuarantee')->name('getGuarantee');
        Route::post('/admin/editguarantee',  'editGuarantee')->name('editGuarantee');
    });

    //Config Categories AUTO
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/admin/category', 'showPage')->name('categoryPage');
        Route::get('/admin/category/{id}', 'getCategory')->name('getCategory');
        Route::post('/admin/editcategory', 'editCategory')->name('editCategory');
    });
	
		
    //gestion des utilisateurs
    Route::controller(UsersManagerController::class)->group(function () {
	    Route::get('/admin/users', 'showUsersList')->name('users.afficher');
        Route::get('/admin/userdetails/{id_user}', 'showUserDetails')->name('userDetails');
        Route::get('/admin/getuser/{id_user}', 'getUser')->name('getUser');
        Route::post('/admin/edituser', 'editUser')->name('user.edit');
        Route::post('/admin/createuser', 'createUser')->name('user.create');
        Route::post('/admin/edituserrole', 'editUserRole')->name('userrole.edit');
        Route::get('/admin/deleteuser/{id_user}', 'deleteUser')->name('deleteUser');
    });

    Route::controller(ContractsController::class)->group(function () {
	    Route::get('/admin/contracts', 'showContracts')->name('contrats');
        Route::get('/admin/rates', 'showRates')->name('configRate');
        Route::post('/admin/editrate', 'editRate')->name('editAutoReduction');
        Route::post('/admin/renewcontract', 'renewContract')->name('renewContract');
        Route::get('/admin/loadcontrat/{id_contrat}', 'loadContrat')->name('loadContrat');
        Route::get('/admin/details-contrat/{id_cont}', 'showDetailsContrat')->name('details-contrat');
    });

    Route::controller(CallMeController::class)->group(function () {
        Route::post('/admin/notification/send_sms', 'sendSMS')->name('sendSMS');
        Route::post('/admin/notification/send_email', 'sendEmail')->name('sendEmail');
        Route::post('/admin/notification/send_sms_simple', 'sendSMSSimple')->name('sendSMSSimple');
        Route::post('/admin/notification/send_email_simple', 'sendEmailSimple')->name('sendEmailSimple');
        Route::get('/admin/notifications/call', 'showCallNotifPage')->name('notiication.call');
        Route::get('/admin/notifications/call/{notif_id}', 'showSingleCallNotifPage')->name('single.notiication.call');
        Route::post('/admin/notifications/call/post', 'postCallNotif')->name('call-me.post');
    });

    Route::controller(RepportsController::class)->group(function () {
        Route::get('/admin/stats/devis', 'showRepportsQuotesPage')->name('stats.devis');    
    });

    Route::controller(ExportDataController::class)->group(function () {
        Route::get('/admin/export-data', 'showExportPage')->name('exportData');
        Route::post('/post/export-client', 'postExportClient')->name('postExportClient');
    });

    Route::controller(AdvancedSearchController::class)->group(function () {
        Route::get('/delete/trace-devis', 'showdeleteTracePage')->name('deleteTrace');
        Route::post('/delete/trace-devis', 'deleteInfoDevisPost')->name('deleteInfoDevisPost');
    });


});

Route::get('/rest-api/v1/autoQuote/{auto_id}/{user_id}/{assur_id}', 'App\Http\Controllers\Quotation\AutoQuotationController@caculAutoQuotationFromDb')->name('autoQuoteBD');

Route::auth();
// Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout'); //Just added to fix issue

Route::get('/', 'App\Http\Controllers\Pages\IndexPageController@showIndexPage')->name('page.index');

Route::get('/rubrique/pourquoi-monassurance-ci', 'App\Http\Controllers\Pages\RubriqueController@showWhyMonAssurance')->name('rubrique.why-monassurance');
Route::get('/rubrique/comment-comparer', 'App\Http\Controllers\Pages\RubriqueController@showHowToCompare')->name('rubrique.how-to-compare');
Route::get('/rubrique/assurance-voyage', 'App\Http\Controllers\Pages\RubriqueController@showInsuranceVoyage')->name('rubrique.travel.insurance');

Route::group(['middleware' => ['auth.persoaccount']], function () {
	Route::get('/myspace', 'App\Http\Controllers\MySpace\MySpaceController@showSpacePage')->name('page.myspace');
	Route::get('/myspace/devis-auto', 'App\Http\Controllers\MySpace\MySpaceController@showAutoQuotationPage')->name('page.myspace.devis-auto');
	Route::get('/myspace/devis-moto', 'App\Http\Controllers\MySpace\MySpaceController@showMotoQuotationPage')->name('page.myspace.devis-moto');
	Route::get('/myspace/devis-voyage', 'App\Http\Controllers\MySpace\MySpaceController@showVoyageQuotationPage')->name('page.myspace.devis-voyage');
	Route::post('/myspace/update-profile', 'App\Http\Controllers\MySpace\MySpaceController@UpdateProfile')->name('page.myspace.update-profile');
	Route::post('/myspace/update-password', 'App\Http\Controllers\MySpace\MySpaceController@updateAccountPassword')->name('page.myspace.update-password');
	Route::post('/myspace/renew-contract', 'App\Http\Controllers\MySpace\MySpaceController@renewContract')->name('page.myspace.renewContract');
	Route::get('/myspace/loadcontrat/{id_contrat}', ['as' => 'loadContrat','uses' => 'App\Http\Controllers\MySpace\MySpaceController@loadContrat']);

	Route::get('/rest-api/v1/searchuser/{id}', ['as' => 'searchUser','uses' => 'App\Http\Controllers\Api\V1\RestAPI@searchTravelProfil']);
});
Route::get('/devis/search', 'App\Http\Controllers\Pages\SearchPageController@showSearchPage')->name('page.search');
Route::post('/devis/search', 'App\Http\Controllers\Pages\SearchPageController@submitSearch')->name('submit.search');
Route::post('/devis/search/sinistre', 'App\Http\Controllers\Pages\SearchPageController@submitSearchSinistre')->name('submit.search.sinistre');

Route::get('/automobile', 'App\Http\Controllers\Pages\ProductPageController@showAutoPage')->name('page.auto');
Route::get('/habitation', 'App\Http\Controllers\Pages\ProductPageController@showHabitationPage')->name('page.habitation');
Route::get('/devis/automobile', 'App\Http\Controllers\Pages\ProductPageController@showAutoQuotationPage')->name('page.quote.auto');
Route::get('/details/devis/{id_quote}/{id_comp}', 'App\Http\Controllers\Pages\ProductPageController@showQuoteDetails')->name('details.quote.auto');
Route::get('/devis/pdf/{comp_id}/{quote_id}', ['as' => 'showDevisPDF','uses' => 'App\Http\Controllers\Pages\ProductPageController@loadDevisPDF']);

Route::get('/devis/contrat/pdf/{comp_id}/{quote_id}', ['as' => 'showContratPDF','uses' => 'App\Http\Controllers\Pages\ProductPageController@loadContratPDF']);

Route::get('/devis/all/{quote_id}', ['as' => 'showDevisAllResult','uses' => 'App\Http\Controllers\Pages\ProductPageController@showDevisAllResult']);
Route::post('/devis/update/guarante', ['as' => 'updateGuaranteAssurance','uses' => 'App\Http\Controllers\Pages\ProductPageController@updateAutoFormule']);
Route::get('/devis/voyage/pdf/{comp_id}/{quote_id}', ['as' => 'showDevisVoyagePDF','uses' => 'App\Http\Controllers\Pages\ProductPageController@loadDevisVoyagePDF']);
Route::get('/devis/automobile/congrate/{id_quote}', 'App\Http\Controllers\Pages\ProductPageController@showAutoCongratePage')->name('page.congrate.auto');
Route::get('/devis/voyage/congrate/{id_quote}', 'App\Http\Controllers\Pages\ProductPageController@showVoyageCongratePage')->name('page.congrate.voyage');

Route::get('/moto', 'App\Http\Controllers\Pages\ProductPageController@showMotoPage')->name('page.moto');
Route::get('/devis/moto', 'App\Http\Controllers\Pages\ProductPageController@showMotoQuotationPage')->name('page.quote.moto');

Route::get('/voyage', 'App\Http\Controllers\Pages\ProductPageController@showVoyagePage')->name('page.voyage');
Route::get('/devis/voyage', 'App\Http\Controllers\Pages\ProductPageController@showVoyageQuotationPage')->name('page.quote.voyage');
Route::get('/voyage/details/devis/{id_quote}/{id_comp}', 'App\Http\Controllers\Pages\ProductPageController@showTravelQuoteDetails')->name('details.quote.travel');

Route::post('/devis/auto/getquotation', ['as'=>'getQuotation','uses'=>'App\Http\Controllers\Pages\ProductPageController@traitAutoQuotation']);

Route::post('/devis/moto/getquotation', ['as'=>'getMotoQuotation','uses'=>'App\Http\Controllers\Pages\ProductPageController@traitMotoQuotation']);

Route::post('/devis/voyage/getquotation', ['as'=>'getVoyageQuotation','uses'=>'App\Http\Controllers\Pages\ProductPageController@traitVoyageQuotation']);
Route::post('/devis/auto/confirmquotation', ['as'=>'confirm.auto.quotation','uses'=>'App\Http\Controllers\Pages\ProductPageController@ConfirmAutoQuotation']);

Route::post('/call-me', 'App\Http\Controllers\Notification\CallMeController@requestCall')->name('callme');

Route::get('/register', 'App\Http\Controllers\MySpace\MySpaceController@createSpace')->name('myspace.register');

Route::get('/sinistres', 'App\Http\Controllers\Pages\ProductPageController@showSinistrePage')->name('page.sinistre');
Route::post('/sinistres/post', 'App\Http\Controllers\Pages\ProductPageController@newSinistre')->name('new.sinistre');

Route::get('/rest-api/v1/searchcar/{immat}', ['as' => 'searchImmat','uses' => 'App\Http\Controllers\Api\V1\RestAPI@searchImmat']);
Route::get('/rest-api/v1/searchmoto/{immat}', ['as' => 'searchImmatMoto','uses' => 'App\Http\Controllers\Api\V1\RestAPI@searchImmatMoto']);

Route::get('/rest-api/v1/getguaranties/{idcomp}/{formule}', ['as' => 'getGuarantiesFormule','uses' => 'App\Http\Controllers\Api\V1\RestAPI@getGuarantiesFormule']);
Auth::routes();

Route::post('/add/newmakecar', 'App\Http\Controllers\Quotation\AutoQuotationController@createNewCarMake')->name('auto-quote.createNewCarMake');
Route::post('/reset/password', 'App\Http\Controllers\Auth\ResetPasswordController@resetPassword')->name('reset.password');
Route::get('/reset/password/otp', 'App\Http\Controllers\Auth\ResetPasswordController@optPage')->name('password.otp');
Route::post('/reset/check/otp', 'App\Http\Controllers\Auth\ResetPasswordController@checkPin')->name('reset.checkpin');
Route::get('/reset/password/token={remember_token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetPasswordPage')->name('password.reset.page');
Route::post('/reset/update/password', 'App\Http\Controllers\Auth\ResetPasswordController@updatePassword')->name('reset.updatepassword');


Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');


Route::get("/surprises", "App\Http\Controllers\PagesController@surprise");