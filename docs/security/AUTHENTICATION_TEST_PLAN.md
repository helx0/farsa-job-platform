# Authentication Security Test Plan

## Current authentication model

The PHP application currently authenticates users with server-side PHP sessions. A JWT implementation is not active in the PHP login flow; the repository contains JWT-related Python dependencies and a PHP JWT secret configuration, but no verified access-token issuance/validation path was found during this review.

Therefore, JWT expiration tests remain a release gate for any future JWT endpoint rather than being treated as currently implemented behavior.

## Login throttling settings

- Maximum failed attempts: 5
- Rolling failure window: 15 minutes
- Lockout duration: 15 minutes
- Throttling dimensions: account email and source IP
- Successful login clears the matching email+IP failure record
- Password failures use the same generic message as unknown accounts to reduce account enumeration

## Manual/API test cases

| ID | Test | Expected result |
|---|---|---|
| AUTH-01 | Correct email + correct password | 200, session created |
| AUTH-02 | Correct email + wrong password | 401, generic error |
| AUTH-03 | Unknown email + any password | 401, same generic error as AUTH-02 |
| AUTH-04 | 5 consecutive failures for the same email/IP | Subsequent login attempts are throttled |
| AUTH-05 | Wait until the 15-minute window expires | Login can be attempted again |
| AUTH-06 | Successful login after failures | Matching failure record is cleared |
| AUTH-07 | Attack one account from one IP, then access a different account from that IP | IP-based throttling remains effective |
| AUTH-08 | Change client IP while attacking one account | Account/email-based throttling still applies |
| AUTH-09 | Suspended account with correct password | Login rejected |
| AUTH-10 | Pending/unverified account with correct password | Login rejected |
| AUTH-11 | Successful login | Session ID changes; previous session ID is invalid |
| AUTH-12 | Logout | Session cookie is expired and server session is destroyed |

## JWT release-gate tests

If JWT authentication is enabled later, require all of the following before release:

1. Access token contains exp, iat, iss, aud, and a subject/user identifier.
2. Expired tokens are rejected with HTTP 401.
3. Tokens with invalid signatures are rejected.
4. Tokens signed with a previous or incorrect secret are rejected.
5. iss and aud are validated.
6. Tokens with a future-invalid nbf are rejected if nbf is used.
7. Access-token lifetime is short (recommended: 15 minutes).
8. Refresh tokens, if introduced, are separate from access tokens and have rotation/revocation controls.
9. JWT secrets/keys are stored outside Git and rotated if exposed.
10. No endpoint trusts a decoded JWT payload before signature and claim validation.

## Production authentication settings

- Use HTTPS only.
- Keep PHP session cookies Secure, HttpOnly, and SameSite=Lax or stricter where compatible.
- Keep DISPLAY_ERRORS=false.
- Use a unique high-entropy JWT_SECRET only if JWT is actually enabled.
- Do not log passwords, access tokens, refresh tokens, reset tokens, or full authentication headers.
- Consider a reverse proxy/WAF rate limit in addition to the application-level throttle.
- Add MFA for administrator accounts before production.
