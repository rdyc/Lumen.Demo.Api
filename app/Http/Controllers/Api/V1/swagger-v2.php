<?php

/**
 * @SWG\Swagger(
 *     schemes={"http", "https"},
 *     host="localhost:8003",
 *     basePath="/v1",
 *     @SWG\Info(
 *         version="1",
 *         title="REST Api Documentation",
 *         description="Representation State Transfer Protocol",
 *         @SWG\Contact(
 *             name="Ruddy Cahyadi",
 *             email="ruddycahyadi@gmail.com"
 *         ),
 *         @SWG\License(
 *             name="Apache 2.0",
 *             url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *         )
 *     )
 * )
 *
 * @SWG\SecurityScheme(
 *   securityDefinition="demo_auth",
 *   type="oauth2",
 *   authorizationUrl="http://localhost:8001/oauth/authorize",
 *   tokenUrl="http://localhost:8001/oauth/token",
 *   flow="implicit",
 *   scopes={
 *     "profiles-read": "Read user profiles",
 *     "profiles-write": "Modify user profiles"
 *   }
 * )
 *
 * @SWG\Parameter(
 *   parameter="RequestedWith",
 *   in="header",
 *   name="X-Requested-With",
 *   description="Determinate as ajax request",
 *   type="string",
 *   required=false,
 *   enum={"XMLHttpRequest"},
 *   default="XMLHttpRequest"
 * )
 *
 * @SWG\Parameter(
 *     parameter="Pagination.Page",
 *     in="query",
 *     name="page",
 *     type="integer",
 *     description="page number to display",
 *     required=false,
 *     default=1
 * )
 *
 * @SWG\Parameter(
 *     parameter="Pagination.Limit",
 *     in="query",
 *     name="limit",
 *     type="integer",
 *     description="limit items per page",
 *     required=false,
 *     default=10
 * )
 * 
 * @SWG\Parameter(
 *     parameter="Sorting",
 *     in="query",
 *     name="sort",
 *     type="string",
 *     description="Sort direction",
 *     required=false,
 *     enum={"asc", "desc"}
 * ),
 *
 * @SWG\Definition(
 *     definition="created",
 *     @SWG\Property(
 *          property="id",
 *          type="integer",
 *          format="int64"
 *     ),
 *     @SWG\Property(
 *          property="created_at",
 *          type="date",
 *          format="date-time"
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="updated",
 *     @SWG\Property(
 *          property="id",
 *          type="integer",
 *          format="int64"
 *     ),
 *     @SWG\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time"
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="error_detail",
 *     @SWG\Property(
 *          property="http_code",
 *          type="integer"
 *     ),
 *     @SWG\Property(
 *          property="status_text",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="message",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="file",
 *          type="string"
 *     )
 * )
 *
 * @SWG\Response(
 *   response="Unauthorized",
 *   description="Unauthorized"
 * ),
 * @SWG\Response(
 *   response="Forbidden",
 *   description="Forbidden"
 * ),
 * @SWG\Response(
 *   response="NotAllowed",
 *   description="Method Not Allowed"
 * ),
 * @SWG\Response(
 *   response="BadRequest",
 *   description="Bad Request"
 * ),
 * @SWG\Response(
 *   response="Accepted",
 *   description="Accepted",
 *   @SWG\Schema(ref="#/definitions/updated")
 * ),
 * @SWG\Response(
 *   response="Created",
 *   description="Created",
 *   @SWG\Schema(ref="#/definitions/created")
 * ),
 * @SWG\Response(
 *   response="GeneralError",
 *   description="General Error",
 *   @SWG\Schema(ref="#/definitions/error_detail")
 * )
 *
 */