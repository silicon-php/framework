<?php

namespace Silicon\Http;

final class CookieEncrypter
{
    private const CIPHER = 'aes-256-gcm';

    public function __construct(
        private string $secret
    ) {
        if (strlen($secret) !== 32) {
            throw new \InvalidArgumentException(
                'Encryption key must be 32 bytes (256 bits)'
            );
        }
    }

    public function encrypt(string $plaintext): string
    {
        $iv = random_bytes(12); // recomendado para GCM
        $tag = '';

        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $this->secret,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($ciphertext === false) {
            throw new \RuntimeException('Encryption failed');
        }

        // iv + tag + ciphertext (binario)
        return base64_encode($iv . $tag . $ciphertext);
    }

    public function decrypt(string $payload): ?string
    {
        $data = base64_decode($payload, true);

        if ($data === false || strlen($data) < 28) {
            return null;
        }

        $iv = substr($data, 0, 12);
        $tag = substr($data, 12, 16);
        $ciphertext = substr($data, 28);

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $this->secret,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return $plaintext === false ? null : $plaintext;
    }
}
