# Subrite OIDC OAuth Integration

This guide will help you seamlessly integrate Subrite OIDC into your application for user authorization using OAuth.

You can use any popular OpenID Connect library in your preferred programming language for a seamless integration experience

## Prerequisites

Before you begin, make sure you have the following information from Subrite's admin portal:

-   **Client ID**
-   **Client Secret**
-   **Redirect URI**

## OAuth Flow Steps

### 1. Redirect to Subrite Login Page

To initiate the OAuth process, users need to be redirected to Subrite's OIDC login page.

**Endpoint:**

```http
GET /api/oidc/auth
```

### Request Parameters:

-   **response_type (required):** Grant to execute. Only code is currently supported.
-   **client_id (required):** Your Client ID.
-   **redirect_uri (required):** A successful response from this endpoint results in a redirect to this URL.
-   **code_challenge_method (required):** S256 (Required as PKCE is enabled).
-   **code_challenge (required):** Base64 encoded SHA256 hashed long character string.
-   **scope (required):** openid, offline_access.
-   **state (required):** An opaque value used for security purposes.

### Example Request

```
GET http://{{subriteUrl}}/api/oidc/auth?client_id=-client-id&response_type=code&scope=openid+offline_access&redirect_uri=http%3A%2F%2Flocalhost%3A3010%2Fcallback&code_challenge=abclongcode&code_challenge_method=S256&state=deflongcode

```

## 2. User Authentication

After being redirected to Subrite's OAuth login page, users will authenticate themselves.

## 3. Exchange Code for acessToken

Upon successful authentication, users will be redirected to the specified redirect_uri with a temporary code. Use this code to obtain an access token.

**Endpoint:**

```http
POST /api/oidc/token
Content-Type: application/x-www-form-urlencoded
```

### Request Parameters

-   **grant_type (required):** authorization_code.
-   **client_id (required):** Your Client ID.
-   **client_secret (required):** Your Client Secret.
-   **code (required):** The code received in the response in step 2.
-   **code_verifier (required):** Code stored in session when generating code_challenge in step 1.

### Response

```
{
  "token_type": "<string>",
  "expires_in": <integer>,
  "access_token": "<string>",
  "refresh_token": "<string>",
  "id_token": "<string>",
  "scope": "<string>"
}
```

## Example token request

```
curl --location '{{subriteUrl}}/api/oidc/token' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Accept: application/json' \
--data-urlencode 'grant_type=authorization_code' \
--data-urlencode 'client_id=YourClientId' \
--data-urlencode 'client_secret=YourClientSecret' \
--data-urlencode 'code=CodeFromStep2' \
--data-urlencode 'code_verifier=CodeVerifierFromStep1'
```

### Using Access Token

Use the obtained access token as authorization bearer token to make requests to Subrite API to access resources.

### Get Refresh Token

To obtain a refresh token, use the same token endpoint with `grant_type` set to `refresh_token`.

### Logout

When implementing logout, ensure to log the user out from Subrite and your application. Make a GET request to Subrite's logout endpoint.

**Logout Endpoint:**

```http
GET /api/oidc/session/end
```

You can also tell subrite what client we are signing out from

```http
GET /api/oidc/session/end?client_id=your_client_id

```

After logout from subrite, you will be redirected to your `post_logout_redirect_uri`.
