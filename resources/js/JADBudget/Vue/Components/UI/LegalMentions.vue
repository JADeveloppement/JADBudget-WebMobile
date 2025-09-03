<template>
    <div class="legalMentions">
        <div class="box">
            <h1>Mentions légales</h1>
            <h2>Introduction</h2>
            <p>
                Conformément aux dispositions de la loi n° 2004-575 du 21 juin 2004 pour la confiance en l'économie numérique, 
                il est précisé aux utilisateurs du site JADeveloppement l'identité des différents intervenants dans le cadre de sa 
                réalisation et de son suivi.
            </p>
            <span></span>
            <h3>Edition du site</h3>
            <p>
                Le présent site, accessible à l'URL <a href="https://jadeveloppement.fr">JADeveloppement.fr</a>, est édité par :
            </p>
            <span></span>
            <p>
                <b>Jalal AISSAOUI</b>
            </p>
            <p>
                <b>Forme juridique : </b> Micro-entreprise <br>
                <b>Adresse : </b> 67000 Strasbourg <br>
                <b>Numéro de téléphone : </b> 07.72.24.48.32 <br>
                <b>Adresse e-mail : </b> <a href="mailto:contact@jadeveloppement.fr">contact@jadeveloppement.fr</a> <br>
                <b>Numéro SIRET : </b> 82947999700035<br>
                <b>Code APE : </b> 6201Z PROGRAMMATION INFORMATIQUE<br>
            </p>
            <span></span>
            <h3>Hébergement</h3>
            <p>Le présent site est hébergé par : <b>Hostinger </b></p>
            <p><b>Adresse : </b>HOSTINGER operations, UAB - Švitrigailos str. 34, Vilnius 03230 Lithuania</p>
            <p><b>Numéro de téléphone : </b>+37064503378</p>
            <p><b>Adresse e-mail : </b>domains@hostinger.com</p>
            <span></span>
            <h3>Directeur de publication</h3>
            <p>
                Le Directeur de la publication du site est : <b>Jalal AISSAOUI</b>
            </p>
            <span></span>
            <h3>Propriété Intellectuelle et Contrefaçons</h3>
            <p>
                <b>JADeveloppement</b> est propriétaire des droits de propriété intellectuelle et détient les droits d'usage 
                sur tous les éléments accessibles sur le site internet, notamment les textes, images, graphismes, logos, vidéos, 
                architecture, icônes et sons. <br><br>
                Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site, 
                quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de <b>Jalal AISSAOUI</b>
                <br><br>
                Toute exploitation non autorisée du site ou de l'un quelconque des éléments qu'il contient sera considérée comme 
                constitutive d'une contrefaçon et poursuivie conformément aux dispositions des articles L.335-2 et suivants du 
                Code de Propriété Intellectuelle.
            </p>
            <span></span>
            <h3>Données Personnelles et Politique de Confidentialité</h3>
            <p>
                Le site JADeveloppement ne collecte pas de données personnelles des utilisateurs, sauf celles que vous pourriez 
                nous communiquer volontairement via un formulaire de contact (adresse e-mail). Ces données sont traitées dans le 
                seul but de répondre à votre demande et ne sont en aucun cas cédées ou vendues à des tiers.
                <br><br>
                Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de 
                rectification, de suppression et d'opposition aux données personnelles vous concernant. Pour exercer ces droits, 
                veuillez nous contacter à l'adresse e-mail suivante : <a href="mailto:contact@jadeveloppement.fr">contact@jadeveloppement.fr</a>
            </p>
            <span></span>
            <h3>Liens Hypertextes</h3>
            <p>
                Le site JADeveloppement peut contenir des liens hypertextes vers d'autres sites et dégage toute responsabilité à 
                propos de ces liens externes ou des liens créés par d'autres sites vers JADeveloppement.
            </p>
            <span></span>
            <h3>Droit Applicable et Attribution de Juridiction</h3>
            <p>
                Tout litige en relation avec l'utilisation du site JADeveloppement est soumis au droit français. En dehors des cas où 
                la loi ne le permet pas, il est fait attribution exclusive de juridiction aux tribunaux compétents de <b>Strasbourg</b>
            </p>
        </div>
    </div>
</template>

<style scoped>
    span {
        margin-top: 1rem;
    }
</style>

<script>
export default{
    data(){
        return {};
    },
    mounted(){
        const legalMentionsContainer = document.querySelector('.legalMentions');
        legalMentionsContainer.addEventListener('click', () => {
            legalMentionsContainer.style.top = "100vh";
        })
    }
}
</script>