import { deprecate } from "../lib/utils/index.js";
import connectAnswers from "./answers/connectAnswers.js";
import connectConfigureRelatedItems from "./configure-related-items/connectConfigureRelatedItems.js";
import connectDynamicWidgets from "./dynamic-widgets/connectDynamicWidgets.js";

/** @deprecated answers is no longer supported */
export var EXPERIMENTAL_connectAnswers = deprecate(connectAnswers, 'answers is no longer supported');

/** @deprecated use connectRelatedItems instead */
export var EXPERIMENTAL_connectConfigureRelatedItems = deprecate(connectConfigureRelatedItems, 'EXPERIMENTAL_connectConfigureRelatedItems is deprecated and will be removed in a next minor version of InstantSearch. Please use connectRelatedItems instead.');

/** @deprecated use connectDynamicWidgets */
export var EXPERIMENTAL_connectDynamicWidgets = deprecate(connectDynamicWidgets, 'use connectDynamicWidgets');
export { connectDynamicWidgets };
export { default as connectClearRefinements } from "./clear-refinements/connectClearRefinements.js";
export { default as connectCurrentRefinements } from "./current-refinements/connectCurrentRefinements.js";
export { default as connectHierarchicalMenu } from "./hierarchical-menu/connectHierarchicalMenu.js";
export { default as connectHits } from "./hits/connectHits.js";
export { default as connectHitsWithInsights } from "./hits/connectHitsWithInsights.js";
export { default as connectHitsPerPage } from "./hits-per-page/connectHitsPerPage.js";
export { default as connectInfiniteHits } from "./infinite-hits/connectInfiniteHits.js";
export { default as connectInfiniteHitsWithInsights } from "./infinite-hits/connectInfiniteHitsWithInsights.js";
export { default as connectMenu } from "./menu/connectMenu.js";
export { default as connectNumericMenu } from "./numeric-menu/connectNumericMenu.js";
export { default as connectPagination } from "./pagination/connectPagination.js";
export { default as connectRange } from "./range/connectRange.js";
export { default as connectRefinementList } from "./refinement-list/connectRefinementList.js";
export { default as connectRelatedProducts } from "./related-products/connectRelatedProducts.js";
export { default as connectSearchBox } from "./search-box/connectSearchBox.js";
export { default as connectSortBy } from "./sort-by/connectSortBy.js";
export { default as connectRatingMenu } from "./rating-menu/connectRatingMenu.js";
export { default as connectStats } from "./stats/connectStats.js";
export { default as connectToggleRefinement } from "./toggle-refinement/connectToggleRefinement.js";
export { default as connectTrendingItems } from "./trending-items/connectTrendingItems.js";
export { default as connectBreadcrumb } from "./breadcrumb/connectBreadcrumb.js";
export { default as connectGeoSearch } from "./geo-search/connectGeoSearch.js";
export { default as connectPoweredBy } from "./powered-by/connectPoweredBy.js";
export { default as connectConfigure } from "./configure/connectConfigure.js";
export { default as connectAutocomplete } from "./autocomplete/connectAutocomplete.js";
export { default as connectQueryRules } from "./query-rules/connectQueryRules.js";
export { default as connectVoiceSearch } from "./voice-search/connectVoiceSearch.js";
export { default as connectRelevantSort } from "./relevant-sort/connectRelevantSort.js";
export { default as connectFrequentlyBoughtTogether } from "./frequently-bought-together/connectFrequentlyBoughtTogether.js";
export { default as connectLookingSimilar } from "./looking-similar/connectLookingSimilar.js";