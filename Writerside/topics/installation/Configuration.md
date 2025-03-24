# Configuration

> %project% **need** change a specific configuration in production environment.

```yaml
# Default configuration for extension with alias: "idm_settings"
idm_settings:
	# key must be generated using sodium_crypto_box_keypair() 
	# and encode with base64_encode. 
	# You need generate your own keypair in PROD environment.
	cache_keypair:
		# Default:
		- !!binary A8sxOR+h35ollRFbQ3KzMDp1gBRbn0UZA0kRjclWRChFgNOF9KTcWg1GNV2rHwnT+0xO3h5Kexpq8MSN+mpOBA==
```

> Remember change value `cache_keypair` with your own keypair value
> {style="warning"}
