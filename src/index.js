import jQuery from 'jquery';
import './style.scss';

import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import postTypeArchiveVideo from './routes/videos';
import pageTemplatePageContact from './routes/contact';
import singleProduct from './routes/products';
import woocommerce from './routes/woocommerce';

const $ = jQuery;

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  /** All pages */
  common,
  /** Home page */
  home,
  /** About Us page, note the change from about-us to aboutUs. */
  postTypeArchiveVideo,
  pageTemplatePageContact,
  singleProduct,
  woocommerce
});

/** Load Events */
jQuery(document).ready(() => routes.loadEvents());
